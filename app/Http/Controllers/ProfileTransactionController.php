<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ProfileTransactionController extends Controller
{
    public function index()
    {
        $status = request('status');
        $query = auth()->user() ? Order::where('user_id', auth()->id()) : Order::query();
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('profile.transactions', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(404);
        }

        $order->load(['items', 'addressRecord', 'pickupLocation', 'designInquiry', 'rating']);

        return view('profile.order-detail', compact('order'));
    }

    public function storeRating(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'success') {
            abort(404);
        }

        if ($order->rating) {
            return back()->with('error', 'You have already rated this order.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);

        $order->rating()->create([
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'review' => $validated['review'] ?? null,
        ]);

        return back()->with('success', __('ui.profile.transactions.rating_saved'));
    }
}
