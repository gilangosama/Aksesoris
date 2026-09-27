<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Models\PickupLocation;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'nullable|integer|min:1'
            ]);

            $product = Product::findOrFail($request->product_id);
            $qty = $request->quantity ?? 1;

            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += $qty;
            } else {
                $cart[$product->id] = [
                    'id' => $product->id,
                    'slug' => $product->slug,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $qty,
                    'image' => $product->image,
                    'category' => $product->category->name ?? 'Jewelry',
                ];
            }

            session(['cart' => $cart]);

            // Return JSON for AJAX requests
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $product->name . ' ' . __('messages.cart.product_added'),
                    'cart_count' => count($cart),
                    'total_items' => array_sum(array_column($cart, 'quantity'))
                ]);
            }

            return Redirect::back()->with('success', __('messages.cart.product_added'));
        } catch (\Exception $e) {
            \Log::error('Add to cart error: ' . $e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => __('messages.cart.add_failed')
                ], 400);
            }
            
            return Redirect::back()->with('error', 'Failed to add to cart');
        }
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required']);
        $cart = session()->get('cart', []);
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session(['cart' => $cart]);
        }

        return Redirect::back();
    }

    // app/Http/Controllers/CartController.php

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if(isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            
            // Return JSON response for AJAX
            return response()->json([
                'success' => true,
                'message' => __('messages.cart.updated')
            ]);
        }

        return response()->json(['success' => false], 404);
    }
    
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', __('messages.cart.empty'));
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $allPickupLocations = PickupLocation::where('is_active', true)->get();
        $pickupLocations = collect();
        $defaultAddress = auth()->user()->addresses->firstWhere('is_default', true) ?? auth()->user()->addresses->first();
        if ($defaultAddress) {
            $normalizedAddressCity = $this->normalizePickupCity($defaultAddress->city);
            $pickupLocations = $allPickupLocations->filter(function ($location) use ($normalizedAddressCity) {
                $normalizedLocationCity = $this->normalizePickupCity($location->city);
                return Str::contains($normalizedLocationCity, $normalizedAddressCity) || Str::contains($normalizedAddressCity, $normalizedLocationCity);
            })->values();
        }

        return view('cart.checkout', [
            'cart' => $cart,
            'total' => $total,
            'allPickupLocations' => $allPickupLocations,
            'pickupLocations' => $pickupLocations,
        ]);
    }

    private function normalizePickupCity(?string $city): string
    {
        $city = trim(Str::lower($city ?? ''));
        $city = preg_replace('/\b(kota|kabupaten|kab|provinsi|prov|jawa barat|jawa tengah|jawa timur|sumatera utara|daerah istimewa yogyakarta)\b/u', '', $city);
        $city = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $city);
        return trim($city);
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'address' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Cart is empty');
        }

        // Clear cart after successful order creation
        session()->forget('cart');
        
        return redirect()->route('profile.transactions')->with('success', 'Order created. Please check payment status.');
    }

    public function clear()
    {
        session()->forget('cart');
        return response()->json(['status' => 'success']);
    }

    public function getCount()
    {
        $cart = session()->get('cart', []);
        $total_items = 0;
        foreach ($cart as $item) {
            $total_items += $item['quantity'];
        }
        return response()->json([
            'cart_count' => count($cart),
            'total_items' => $total_items
        ]);
    }
}
