<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PickupLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Configure Midtrans
        Config::$serverKey = config('midtrans.midtrans.server_key');
        Config::$clientKey = config('midtrans.midtrans.client_key');
        Config::$isProduction = config('midtrans.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Process checkout and create order
     */
    public function process(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'delivery_method' => 'required|in:delivery,pickup',
            'address_id' => 'required|exists:addresses,id',
            'pickup_location_id' => 'required_if:delivery_method,pickup|nullable|exists:pickup_locations,id',
            'is_gift' => 'boolean',
            'gift_message' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $user = auth()->user();
            $cart = session()->get('cart', []);

            // Validasi cart tidak kosong
            if (empty($cart)) {
                return response()->json([
                    'success' => false,
                    'message' => __('messages.cart.empty')
                ], 400);
            }

            // 2. Hitung ulang total di backend (JANGAN percaya frontend)
            $total = 0;
            $items = [];
            
            foreach ($cart as $productId => $item) {
                $total += $item['price'] * $item['quantity'];
                $items[] = [
                    'id' => 'PRODUCT-' . $productId,
                    'price' => (int)$item['price'],
                    'quantity' => (int)$item['quantity'],
                    'name' => $item['name']
                ];
            }

            // Minimum transaction amount for Midtrans
            if ($total < 10000) {
                return response()->json([
                    'success' => false,
                    'message' => __('messages.checkout.minimum_amount')
                ], 400);
            }

            // 3. Buat Order ID dan prepare data FIRST
            $orderId = 'ORDER-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(8)) . '-' . time();
            $orderNumber = 'ORD-' . strtoupper(uniqid());
            
            // Get address untuk phone
            $address = $user->addresses()->where('id', $request->address_id)->first();
            $phoneNumber = $address->phone ?? $user->phone ?? '-';

            $pickupLocation = null;
            if ($request->delivery_method === 'pickup') {
                $pickupLocation = PickupLocation::where('id', $request->pickup_location_id)
                    ->where('is_active', true)
                    ->first();

                if (!$pickupLocation) {
                    return response()->json([
                        'success' => false,
                        'message' => __('messages.checkout.pickup_location_unavailable')
                    ], 400);
                }

                $normalizedAddressCity = $this->normalizePickupCity($address->city);
                $normalizedLocationCity = $this->normalizePickupCity($pickupLocation->city);

                if (!Str::contains($normalizedLocationCity, $normalizedAddressCity) && !Str::contains($normalizedAddressCity, $normalizedLocationCity)) {
                    return response()->json([
                        'success' => false,
                        'message' => __('messages.checkout.pickup_location_city_mismatch')
                    ], 400);
                }
            }

            // Prepare Midtrans payload FIRST - validate payment setup before saving order
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $total,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $phoneNumber,
                ],
                'item_details' => $items,
            ];

            // Request Snap Token FIRST - before saving order
            $snapToken = Snap::getSnapToken($params);

            // Validate snap token generation
            if (!$snapToken) {
                throw new \Exception('Failed to generate Midtrans Snap token - empty response from Midtrans API');
            }

            // Ensure snap token is a string
            if (!is_string($snapToken)) {
                throw new \Exception('Invalid Midtrans Snap token format - expected string, got ' . gettype($snapToken));
            }

            // NOW save order after confirming payment setup works
            $order = new Order();
            $order->order_id = $orderId;
            $order->order_number = $orderNumber;
            $order->user_id = $user->id;
            $order->address_id = $request->address_id;
            $order->pickup_location_id = $request->delivery_method === 'pickup' ? $pickupLocation?->id : null;
            $order->delivery_method = $request->delivery_method;
            $order->amount = $total;
            $order->total_price = $total;
            $order->customer_name = $user->name;
            $order->customer_email = $user->email;
            $order->customer_phone = $phoneNumber;
            $order->status = 'pending';
            $order->is_gift = $request->has('is_gift') && $request->is_gift;
            $order->gift_message = $request->gift_message;
            $order->snap_token = $snapToken;
            
            // Save address text for reference
            if ($request->delivery_method === 'pickup' && $pickupLocation) {
                $order->address = "Pickup: {$pickupLocation->name}, {$pickupLocation->address}, {$pickupLocation->city}";
            } elseif ($address) {
                $order->address = "{$address->recipient_name}, {$address->street}, {$address->city}, {$address->province} {$address->postal_code}";
            }
            
            $order->save();

            // 4. Pindahkan Cart Items ke Order Items
            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_name' => $item['name'],
                    'quantity' => (int)$item['quantity'],
                    'price' => (int)$item['price'],
                ]);
            }

            // 5. Kosongkan keranjang
            session()->forget('cart');

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle success payment
     */
    public function success(Request $request)
    {
        $order = Order::find($request->order_id);

        if (!$order || $order->user_id !== auth()->id()) {
            abort(404);
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Handle pending payment
     */
    public function pending()
    {
        return view('checkout.pending');
    }

    private function normalizePickupCity(?string $city): string
    {
        $city = trim(Str::lower($city ?? ''));
        $city = preg_replace('/\b(kota|kabupaten|kab|provinsi|prov|jawa barat|jawa tengah|jawa timur|sumatera utara|daerah istimewa yogyakarta)\b/u', '', $city);
        $city = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $city);
        return trim($city);
    }
}
