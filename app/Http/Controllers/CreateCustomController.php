<?php

namespace App\Http\Controllers;

use App\Models\Charm;
use App\Models\ChainStyle;
use App\Models\CustomizableJewelry;
use App\Models\DesignInquiry;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PickupLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;

class CreateCustomController extends Controller
{
    /**
     * Show step 1: Select jewelry type
     */
    public function selectType()
    {
        // Fetch active customizable jewelry types from database
        $jewelryData = CustomizableJewelry::where('is_active', true)->get();
        
        $types = [];
        foreach ($jewelryData as $jewelry) {
            $types[$jewelry->type] = [
                'label' => $jewelry->label,
                'icon' => $jewelry->icon,
                'image' => $jewelry->image,
                'price' => $jewelry->base_price,
                'description' => $jewelry->description,
            ];
        }

        return view('create-custom.select-type', compact('types'));
    }

    /**
     * Show step 2: Select finish (chain type)
     */
    public function selectFinish(Request $request)
    {
        $type = $request->query('type');
        
        // Validate type exists in database and is active
        $jewelry = CustomizableJewelry::where('type', $type)->where('is_active', true)->first();
        if (!$jewelry) {
            return redirect()->route('create-custom.type');
        }

        $finishes = [
            'silver' => ['label' => 'Silver Chain', 'icon' => '⚪', 'description' => 'Classic silver finish', 'color' => 'silver'],
            'gold' => ['label' => 'Gold Chain', 'icon' => '💛', 'description' => 'Luxurious gold finish', 'color' => 'gold'],
        ];

        return view('create-custom.select-finish', compact('type', 'finishes'));
    }

    /**
     * Show step 3: Select chain style
     */
    public function selectChainStyle(Request $request)
    {
        $type = $request->query('type');
        $finish = $request->query('finish');
        
        // Validate type and finish
        $jewelry = CustomizableJewelry::where('type', $type)->where('is_active', true)->first();
        if (!$jewelry || !in_array($finish, ['silver', 'gold'])) {
            return redirect()->route('create-custom.type');
        }

        // Fetch chain styles for this specific jewelry type and finish from database
        $chainStyles = ChainStyle::where('customizable_jewelry_id', $jewelry->id)
            ->where('finish', $finish)
            ->where('is_active', true)
            ->get();

        if ($chainStyles->isEmpty()) {
            return redirect()->route('create-custom.finish', ['type' => $type])
                ->with('error', 'No chain styles available for this finish');
        }

        return view('create-custom.select-chain-style', compact('type', 'finish', 'chainStyles'));
    }

    /**
     * Show step 4: Select charm/pendant (Final step with preview)
     */
    public function selectCharm(Request $request)
    {
        $type = $request->query('type');
        $finish = $request->query('finish');
        $chain_style = $request->query('chain_style');
        $chain_size = $request->query('chain_size');

        // Validate inputs
        $jewelry = CustomizableJewelry::where('type', $type)->where('is_active', true)->first();
        $chainStyleObj = ChainStyle::find($chain_style);

        if (!$jewelry || !$chainStyleObj || !in_array($finish, ['silver', 'gold'])) {
            return redirect()->route('create-custom.type');
        }

        if (!empty($chainStyleObj->sizes) && count($chainStyleObj->sizes) > 0) {
            $validSizes = collect($chainStyleObj->sizes)->pluck('label')->all();
            if (empty($chain_size) || !in_array($chain_size, $validSizes)) {
                return redirect()->route('create-custom.chain-size', ['type' => $type, 'finish' => $finish, 'chain_style' => $chain_style]);
            }
        }

        // Get total space for selected chain size
        $totalSpace = 8; // default
        if ($chain_size && !empty($chainStyleObj->sizes)) {
            $selectedSize = collect($chainStyleObj->sizes)->firstWhere('label', $chain_size);
            if ($selectedSize) {
                $totalSpace = $selectedSize['total_space'] ?? 8;
            }
        }

        // Fetch all active charms (universal for all jewelry types)
        $charms = Charm::where('is_active', true)->get();

        if ($charms->isEmpty()) {
            return redirect()->route('create-custom.chain-style', ['type' => $type, 'finish' => $finish])
                ->with('error', 'No charms available');
        }

        // Check for existing draft inquiry
        $existingInquiry = null;
        $selectedCharms = [];
        $charmPositions = [];

        if (auth()->check()) {
            $existingInquiry = DesignInquiry::where('user_id', auth()->id())
                ->where('type', $type)
                ->where('finish', $finish)
                ->where('chain_style_id', $chain_style)
                ->where('chain_size', $chain_size)
                ->with('charmDesignItems.charm')
                ->first();

            if ($existingInquiry && $existingInquiry->charmDesignItems->count() > 0) {
                // Build selected charms array with quantities
                $charmCounts = [];
                foreach ($existingInquiry->charmDesignItems as $item) {
                    $charmId = $item->charm_id;
                    if (!isset($charmCounts[$charmId])) {
                        $charmCounts[$charmId] = 0;
                    }
                    $charmCounts[$charmId]++;

                    // Store position data
                    $charmPositions[] = [
                        'charm_id' => $charmId,
                        'x' => $item->charm_position_x,
                        'y' => $item->charm_position_y,
                        'instance_idx' => $charmCounts[$charmId] - 1
                    ];
                }

                $selectedCharms = $charmCounts;
            }
        }

        // Pass jewelry and chain style info for preview
        return view('create-custom.select-charm', compact(
            'type',
            'finish',
            'chain_style',
            'chain_size',
            'jewelry',
            'chainStyleObj',
            'charms',
            'totalSpace',
            'existingInquiry',
            'selectedCharms',
            'charmPositions'
        ));
    }

    /**
     * Show step 4: Select chain size for the chosen chain style
     */
    public function selectChainSize(Request $request)
    {
        $type = $request->query('type');
        $finish = $request->query('finish');
        $chain_style = $request->query('chain_style');

        $jewelry = CustomizableJewelry::where('type', $type)->where('is_active', true)->first();
        $chainStyleObj = ChainStyle::find($chain_style);

        if (!$jewelry || !$chainStyleObj || !in_array($finish, ['silver', 'gold'])) {
            return redirect()->route('create-custom.type');
        }

        if (empty($chainStyleObj->sizes) || count($chainStyleObj->sizes) === 0) {
            return redirect()->route('create-custom.charm', [
                'type' => $type,
                'finish' => $finish,
                'chain_style' => $chain_style,
            ]);
        }

        $chainStyleObj->sizes = collect($chainStyleObj->sizes)
            ->sortByDesc(fn ($item) => data_get($item, 'recommended', false) ? 1 : 0)
            ->values()
            ->all();

        return view('create-custom.select-chain-size', compact('type', 'finish', 'chain_style', 'chainStyleObj', 'jewelry'));
    }

    /**
     * Store the design inquiry
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'finish' => 'required|in:silver,gold',
            'chain_style' => 'required|exists:chain_styles,id',
            'chain_size' => 'nullable|string',
            'charms' => 'required|array|min:1',
            'charms.*' => 'required|integer|exists:charms,id',
            'charm_positions' => 'required|json',
            'description' => 'nullable|string|max:500',
            'budget' => 'nullable|numeric|min:0',
        ]);

        // Validate charm space usage
        $chainStyleObj = ChainStyle::find($validated['chain_style']);
        $totalSpace = 0;
        
        if ($validated['chain_size'] && !empty($chainStyleObj->sizes)) {
            // Find the selected chain size and get its total_space
            $selectedSize = collect($chainStyleObj->sizes)->firstWhere('label', $validated['chain_size']);
            if ($selectedSize) {
                $totalSpace = $selectedSize['total_space'] ?? 8;
            }
        }

        // Calculate space used by selected charms
        $spaceUsed = 0;
        foreach ($validated['charms'] as $charmId) {
            $charm = Charm::find($charmId);
            if ($charm) {
                $spaceUsed += $charm->space_required;
            }
        }

        // Validate space usage
        if ($spaceUsed > $totalSpace) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['charms' => "Space limit exceeded! Used $spaceUsed of $totalSpace units. Please remove some charms."]);
        }

        // Parse charm positions JSON
        $charmPositions = json_decode($validated['charm_positions'], true);

        // Store in session for unauthenticated users or create inquiry directly
        if (auth()->check()) {
            // Check if user already has a draft inquiry for these parameters
            $inquiry = DesignInquiry::where('user_id', auth()->id())
                ->where('type', $validated['type'])
                ->where('finish', $validated['finish'])
                ->where('chain_style_id', $validated['chain_style'])
                ->where('chain_size', $validated['chain_size'])
                ->first();

            if ($inquiry) {
                // Update existing inquiry
                $inquiry->update([
                    'description' => $validated['description'] ?? '',
                    'budget' => $validated['budget'] ?? 0,
                ]);

                // Remove existing charm items
                $inquiry->charmDesignItems()->delete();
            } else {
                // Create new inquiry
                $inquiry = DesignInquiry::create([
                    'user_id' => auth()->id(),
                    'type' => $validated['type'],
                    'finish' => $validated['finish'],
                    'chain_style_id' => $validated['chain_style'],
                    'chain_size' => $validated['chain_size'] ?? null,
                    'description' => $validated['description'] ?? '',
                    'budget' => $validated['budget'] ?? 0,
                ]);
            }

            // Store each charm instance separately so duplicate charms are preserved
            $positions = [];
            foreach ($charmPositions as $charmPosition) {
                $positions[] = [
                    'charm_id' => $charmPosition['charm_id'],
                    'charm_position_x' => $charmPosition['x'],
                    'charm_position_y' => $charmPosition['y'],
                ];
            }
            $inquiry->charmDesignItems()->createMany($positions);

            // Redirect to checkout with design inquiry modal
            return redirect()->route('checkout.custom-design', ['inquiry_id' => $inquiry->id]);
        } else {
            // Store in session for guest users
            session()->put('design_inquiry', $validated);
            return redirect()->route('login')->with('message', 'Please login to complete your custom design request');
        }
    }

    /**
     * Show checkout page with design review modal
     */
    public function checkoutDesign($inquiry_id)
    {
        $inquiry = DesignInquiry::with(['chainStyle', 'charmDesignItems.charm', 'user'])->findOrFail($inquiry_id);
        
        // Ensure user owns this inquiry
        if ($inquiry->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $calculatedTotal = $this->calculateDesignTotal($inquiry);

        // Get user addresses
        $addresses = auth()->user()->addresses;

        $allPickupLocations = PickupLocation::where('is_active', true)->get();
        $pickupLocations = $allPickupLocations;
        
        return view('create-custom.checkout', compact('inquiry', 'addresses', 'pickupLocations', 'allPickupLocations', 'calculatedTotal'));
    }

    /**
     * Process payment for custom design
     */
    public function processCustomDesignPayment(Request $request, $inquiry_id)
    {
        // Configure Midtrans
        Config::$serverKey = config('midtrans.midtrans.server_key');
        Config::$clientKey = config('midtrans.midtrans.client_key');
        Config::$isProduction = config('midtrans.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $validated = $request->validate([
            'delivery_method' => 'required|in:delivery,pickup',
            'address_id' => 'required|exists:addresses,id',
            'pickup_location_id' => 'required_if:delivery_method,pickup|nullable|exists:pickup_locations,id',
            // total_price is retained for backwards-compatible clients, but is
            // intentionally not trusted; the server calculates it below.
            'total_price' => 'nullable|numeric',
            'is_gift' => 'boolean',
            'gift_message' => 'nullable|string|max:500',
            'design_preview_image' => 'nullable|string', // Base64 image data
        ]);

        $inquiry = DesignInquiry::with(['chainStyle', 'charmDesignItems.charm'])->findOrFail($inquiry_id);
        
        // Ensure user owns this inquiry
        if ($inquiry->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $calculatedTotal = $this->calculateDesignTotal($inquiry);
        if ($calculatedTotal < 10000) {
            return response()->json([
                'success' => false,
                'message' => 'Order total must be at least Rp 10,000'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $user = auth()->user();
            
            // Get address untuk phone and city validation
            $address = $user->addresses()->where('id', $validated['address_id'])->first();
            if (!$address) {
                throw new \Exception('Selected delivery address not found');
            }
            $phoneNumber = $address->phone ?? $user->phone ?? '-';

            $pickupLocation = null;
            if ($validated['delivery_method'] === 'pickup') {
                $pickupLocation = PickupLocation::where('id', $validated['pickup_location_id'])
                    ->where('is_active', true)
                    ->first();

                if (!$pickupLocation) {
                    throw new \Exception('Selected pickup location is unavailable');
                }
            }
            
            // Create Order ID first
            $orderId = 'CUSTOM-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(8)) . '-' . time();
            $orderNumber = 'ORD-' . strtoupper(uniqid());
            
            // Prepare Midtrans payload FIRST - validate payment setup before saving order
            $items = [
                [
                    'id' => 'CUSTOM-' . $inquiry->id,
                    'price' => $calculatedTotal,
                    'quantity' => 1,
                    'name' => ucfirst(str_replace('_', ' ', $inquiry->type)) . ' - Custom Design'
                ]
            ];

            $payload = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $calculatedTotal,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $phoneNumber,
                ],
                'items' => $items,
            ];

            // Request Snap Token FIRST - before saving order
            // This ensures we can validate Midtrans setup before creating order record
            $snapToken = Snap::getSnapToken($payload);

            // Validate snap token generation
            if (!$snapToken) {
                throw new \Exception('Failed to generate Midtrans Snap token - empty response from Midtrans API');
            }

            // Ensure snap token is a string
            if (!is_string($snapToken)) {
                throw new \Exception('Invalid Midtrans Snap token format - expected string, got ' . gettype($snapToken));
            }

            // Save or generate design preview snapshot
            $designSnapshot = $validated['design_preview_image'] ?? null;
            
            // If client capture failed, generate fallback snapshot from server
            if (empty($designSnapshot)) {
                \Log::warning('Design snapshot empty from client, generating server-side fallback for inquiry ' . $inquiry->id);
                $designSnapshot = $this->generateDesignSnapshotFallback($inquiry);
            }
            
            if ($designSnapshot) {
                $inquiry->design_snapshot = $designSnapshot;
                $inquiry->save();
                \Log::info('Design snapshot saved for inquiry ' . $inquiry->id . ', size: ' . strlen($designSnapshot) . ' bytes');
            } else {
                \Log::warning('Failed to generate design snapshot for inquiry ' . $inquiry->id);
            }

            // NOW save order after confirming payment setup works
            $order = new Order();
            $order->order_id = $orderId;
            $order->order_number = $orderNumber;
            $order->user_id = $user->id;
            $order->address_id = $validated['address_id'];
            $order->pickup_location_id = $validated['delivery_method'] === 'pickup' ? $pickupLocation->id : null;
            $order->delivery_method = $validated['delivery_method'];
            $order->amount = $calculatedTotal;
            $order->total_price = $calculatedTotal;
            $order->customer_name = $user->name;
            $order->customer_email = $user->email;
            $order->customer_phone = $phoneNumber;
            $order->status = 'pending';
            $order->is_gift = $request->has('is_gift') && $request->is_gift;
            $order->gift_message = $request->gift_message ?? null;
            $order->design_inquiry_id = $inquiry->id;
            $order->snap_token = $snapToken;
            
            // Save address text for reference
            if ($validated['delivery_method'] === 'pickup' && $pickupLocation) {
                $order->address = "Pickup: {$pickupLocation->name}, {$pickupLocation->address}, {$pickupLocation->city}";
            } elseif ($address) {
                $order->address = "{$address->recipient_name}, {$address->street}, {$address->city}, {$address->province} {$address->postal_code}";
            }
            
            $order->save();

            // Create Order Item for custom design
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => null,
                'product_name' => ucfirst(str_replace('_', ' ', $inquiry->type)) . ' - Custom Design',
                'quantity' => 1,
                'price' => $calculatedTotal,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->id,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Custom Design Checkout Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'inquiry_id' => $inquiry_id,
                'user_id' => auth()->id(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate the custom design price from server-owned catalog values.
     * Chain styles currently have no price column, so only the configured
     * jewelry base price and each selected charm's price_add are included.
     */
    private function calculateDesignTotal(DesignInquiry $inquiry): int
    {
        $jewelry = CustomizableJewelry::where('type', $inquiry->type)
            ->where('is_active', true)
            ->first();

        if (!$jewelry || !$inquiry->chainStyle || !$inquiry->chainStyle->is_active) {
            abort(422, 'The selected design is no longer available.');
        }

        $total = (int) round((float) $jewelry->base_price);
        foreach ($inquiry->charmDesignItems as $item) {
            if (!$item->charm) {
                abort(422, 'The selected design contains an unavailable charm.');
            }
            $total += (int) round((float) $item->charm->price_add);
        }

        return $total;
    }

    /**
     * Generate fallback design snapshot when client capture fails
     * Creates a composite image from chain + charms data
     */
    private function generateDesignSnapshotFallback(DesignInquiry $inquiry)
    {
        try {
            // If html2canvas failed on client, generate placeholder composite from server
            // For now, generate a simple HTML+SVG and convert to base64 image
            
            $chainImage = $inquiry->chainStyle?->image;
            if ($chainImage && !filter_var($chainImage, FILTER_VALIDATE_URL)) {
                $chainImage = asset('storage/' . ltrim($chainImage, '/'));
            }
            
            // Create SVG with text info as fallback (minimal but valid)
            $svg = '<svg width="500" height="500" xmlns="http://www.w3.org/2000/svg">';
            $svg .= '<defs><style>';
            $svg .= 'rect { fill: #fff5f8; stroke: #e5b5ca; stroke-width: 2; }';
            $svg .= 'text { font-family: Arial; font-size: 14px; fill: #333; }';
            $svg .= '</style></defs>';
            $svg .= '<rect x="10" y="10" width="480" height="480" rx="8"/>';
            $svg .= '<text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle">';
            $svg .= ucfirst(str_replace('_', ' ', $inquiry->type)) . ' - ' . count($inquiry->charms) . ' charm(s)';
            $svg .= '</text>';
            $svg .= '</svg>';
            
            // Encode SVG as data URI
            $dataUri = 'data:image/svg+xml;base64,' . base64_encode($svg);
            
            \Log::info('Generated server-side fallback snapshot for inquiry ' . $inquiry->id);
            return $dataUri;
        } catch (\Exception $e) {
            \Log::error('Failed to generate snapshot fallback', [
                'inquiry_id' => $inquiry->id,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}
