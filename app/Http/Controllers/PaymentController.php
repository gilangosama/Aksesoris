<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\MidtransService;
use App\Notifications\OrderPlacedAdminNotification;
use App\Notifications\OrderConfirmationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Show payment page
     */
    public function checkout(Request $request)
    {
        // Validasi request
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'address_id' => 'nullable|integer|exists:addresses,id',
            'description' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => ['required', 'string', 'regex:/^PRODUCT-\d+$/'],
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $items = [];
        $amount = 0;
        foreach ($validated['items'] as $item) {
            $productId = (int) Str::after($item['id'], 'PRODUCT-');
            $product = Product::whereKey($productId)->where('is_active', true)->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is no longer available'
                ], 422);
            }

            $quantity = (int) $item['quantity'];
            $amount += (int) $product->price * $quantity;
            $items[] = [
                'id' => 'PRODUCT-' . $product->id,
                'price' => (int) $product->price,
                'quantity' => $quantity,
                'name' => $product->name,
            ];
        }

        if ($amount < 10000) {
            return response()->json([
                'success' => false,
                'message' => 'Order total must be at least Rp 10,000'
            ], 422);
        }

        // Generate order ID (unique)
        $orderId = 'ORDER-' . Str::upper(Str::random(8)) . '-' . time();

        // Prepare order data
        $orderData = [
            'order_id' => $orderId,
            'user_id' => auth()->id(),
            'amount' => $amount,
            'status' => 'pending',
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
        ];

        // If address_id provided, use it; otherwise use raw address text
        if ($request->filled('address_id')) {
            $orderData['address_id'] = $validated['address_id'];
            // Also get the address text for reference
            $addressRecord = \App\Models\Address::whereKey($validated['address_id'])
                ->where('user_id', auth()->id())
                ->first();
            if ($addressRecord && $addressRecord->user_id === auth()->id()) {
                $orderData['address'] = $addressRecord->address;
                $orderData['customer_phone'] = $addressRecord->phone;
            }
        } else {
            $orderData['address'] = $validated['address'] ?? null;
        }

        // Save order to database (pending)
        $order = Order::create($orderData);

        // Save order items to database
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'] ?? 0,
                'product_name' => $item['name'] ?? 'Item',
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        // Format payment data untuk Midtrans
        $paymentData = $this->midtransService->formatPaymentData(
            $orderId,
            $amount,
            $validated['customer_email'],
            $validated['customer_name'],
            $items
        );

        // Create transaction with Midtrans
        $result = $this->midtransService->createTransaction($paymentData);

        if ($result['status'] === 'error') {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'success' => true,
            'snap_token' => $result['snap_token'],
            'order_id' => $orderId
        ]);
    }

    /**
     * Handle payment notification from Midtrans
     */
    public function notification(Request $request)
    {
        $notifBody = $request->getContent();
        $notifData = json_decode($notifBody, true);

        if (!is_array($notifData) || !isset($notifData['order_id'], $notifData['transaction_status'], $notifData['status_code'], $notifData['gross_amount'], $notifData['signature_key'])) {
            return response()->json(['message' => 'Invalid notification'], 400);
        }

        $orderId = $notifData['order_id'];
        $transactionStatus = $notifData['transaction_status'] ?? null;
        $paymentType = $notifData['payment_type'] ?? null;
        $expectedSignature = hash('sha512', $orderId . $notifData['status_code'] . $notifData['gross_amount'] . config('services.midtrans.server_key'));

        if (!hash_equals($expectedSignature, (string) $notifData['signature_key'])) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        \Log::info('Midtrans Notification', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'payment_type' => $paymentType
        ]);

        // Find order by order_id
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        $grossAmount = (int) round((float) $notifData['gross_amount']);
        $orderAmount = (int) round((float) ($order->total_price ?? $order->amount));
        if ($grossAmount !== $orderAmount) {
            return response()->json(['message' => 'Gross amount mismatch'], 422);
        }

        // Midtrans can retry notifications. Do not downgrade a terminal state.
        $newStatus = null;
        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            $newStatus = 'completed';
        } elseif ($transactionStatus === 'pending') {
            $newStatus = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'], true)) {
            $newStatus = 'failed';
        } else {
            return response()->json(['status' => 'ok']);
        }

        $shouldNotify = false;
        DB::transaction(function () use ($order, $newStatus, $notifData, $paymentType, &$shouldNotify) {
            $order = Order::whereKey($order->getKey())->lockForUpdate()->first();
            if ($order->status === 'completed' || ($order->status === 'failed' && $newStatus !== 'completed')) {
                return;
            }
            $shouldNotify = $newStatus === 'completed' && $order->status !== 'completed';
            $order->status = $newStatus;
            $order->transaction_id = $notifData['transaction_id'] ?? $order->transaction_id;
            $order->payment_method = $paymentType ?? $order->payment_method;
            $order->save();
        });

        if ($newStatus === 'completed' && $shouldNotify) {
            // Payment success
            // 📧 Send notifications
            try {
                // Send email ke Admin
                $adminEmail = config('app.admin_email', 'admin@aksesoris.com');
                Notification::route('mail', $adminEmail)
                    ->notify(new OrderPlacedAdminNotification($order));
                
                // Send email ke Customer
                $order->user->notify(new OrderConfirmationNotification($order));
                
                \Log::info("Notification emails sent for Order: {$orderId}");
            } catch (\Exception $e) {
                \Log::error("Failed to send notifications: " . $e->getMessage());
            }
            
            \Log::info("Payment Success for Order: {$orderId}");
        } elseif ($newStatus === 'pending') {
            \Log::info("Payment Pending for Order: {$orderId}");
        } elseif ($newStatus === 'failed') {
            \Log::info("Payment Failed/Cancelled for Order: {$orderId}");
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Get transaction status
     */
    public function status($orderId)
    {
        $order = Order::where('user_id', auth()->id())
            ->where(function ($query) use ($orderId) {
                $query->where('order_id', $orderId)->orWhere('id', $orderId);
            })->first();
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        // Check Midtrans for latest status
        $result = $this->midtransService->getTransactionStatus($order->order_id);

        if ($result['status'] === 'success' && isset($result['data']->transaction_status)) {
            $transactionStatus = $result['data']->transaction_status;
            
            // Update order status if payment is confirmed
            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                if ($order->status !== 'completed') {
                    $order->status = 'completed';
                    $order->transaction_id = $result['data']->transaction_id ?? null;
                    $order->payment_method = $result['data']->payment_type ?? null;
                    $order->save();
                    \Log::info("Status Synced - Payment Success for Order: {$order->order_id}");
                }
            } elseif ($transactionStatus === 'pending') {
                if (!in_array($order->status, ['pending', 'completed', 'failed'], true)) {
                    $order->status = 'pending';
                    $order->save();
                }
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                if (!in_array($order->status, ['completed', 'failed'], true)) {
                    $order->status = 'failed';
                    $order->save();
                }
            }
        }

        $midtransStatus = $result['status'] === 'success'
            ? ($result['data']->transaction_status ?? null)
            : null;

        return response()->json([
            'success' => true,
            'order_status' => $order->status,
            'midtrans_status' => $midtransStatus,
            'data' => [
                'order_id' => $order->order_id,
                'status' => $order->status,
                'amount' => $order->amount,
                'transaction_id' => $order->transaction_id,
                'payment_method' => $order->payment_method,
            ]
        ]);
    }

    /**
     * Synchronize order status with Midtrans (for immediate post-payment sync)
     */
    public function syncStatus(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer',
        ]);

        $order = Order::find($validated['order_id']);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        // Ensure user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Check Midtrans for latest status
        $result = $this->midtransService->getTransactionStatus($order->order_id);

        if ($result['status'] === 'success' && isset($result['data']->transaction_status)) {
            $transactionStatus = $result['data']->transaction_status;
            
            // Update order status if payment is confirmed
            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                $order->status = 'completed';
                $order->transaction_id = $result['data']->transaction_id ?? null;
                $order->payment_method = $result['data']->payment_type ?? null;
                $order->save();
                
                // 📧 Send notifications (in case webhook didn't fire)
                try {
                    // Send email ke Admin
                    $adminEmail = config('app.admin_email', 'admin@aksesoris.com');
                    Notification::route('mail', $adminEmail)
                        ->notify(new OrderPlacedAdminNotification($order));
                    
                    // Send email ke Customer
                    $order->user->notify(new OrderConfirmationNotification($order));
                    
                    \Log::info("Notification emails sent for Order (via sync): {$order->order_id}");
                } catch (\Exception $e) {
                    \Log::error("Failed to send notifications (sync): " . $e->getMessage());
                }
                
                \Log::info("Immediate Sync - Payment Success for Order: {$order->order_id}");
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                if ($order->status !== 'completed') {
                    $order->status = 'failed';
                    $order->save();
                }
            }
        }

        return response()->json([
            'success' => true,
            'order_status' => $order->status,
            'message' => 'Status synchronized successfully'
        ]);
    }
}
