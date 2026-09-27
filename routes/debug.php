<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug-jewelry', function () {
    $jewelry = \App\Models\CustomizableJewelry::all();
    
    echo "<pre>";
    foreach ($jewelry as $item) {
        echo "Type: {$item->type}\n";
        echo "Label: {$item->label}\n";
        echo "Image: " . ($item->image ?? 'NULL') . "\n";
        echo "Image URL: " . asset('storage/' . ($item->image ?? '')) . "\n";
        echo "---\n";
    }
    echo "</pre>";
});

Route::get('/debug/addresses', function () {
    $user = \App\Models\User::first();
    if (!$user) {
        return response()->json(['error' => 'No users found'], 404);
    }
    
    $addresses = \App\Models\Address::where('user_id', $user->id)->get();
    
    return response()->json([
        'user_id' => $user->id,
        'user_name' => $user->name,
        'addresses_count' => $addresses->count(),
        'addresses' => $addresses->map(function ($addr) {
            return [
                'id' => $addr->id,
                'recipient_name' => $addr->recipient_name,
                'street' => $addr->street,
                'city' => $addr->city,
                'province' => $addr->province,
                'postal_code' => $addr->postal_code,
                'phone' => $addr->phone,
                'is_default' => $addr->is_default,
            ];
        }),
    ]);
});

Route::get('/debug/orders', function () {
    $orders = \App\Models\Order::with(['orderItems'])->limit(5)->get();
    
    return response()->json([
        'total_orders' => \App\Models\Order::count(),
        'recent_orders' => $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'order_id' => $order->order_id,
                'status' => $order->status,
                'amount' => $order->amount,
                'address_id' => $order->address_id,
                'design_inquiry_id' => $order->design_inquiry_id,
                'order_items_count' => $order->orderItems->count(),
                'order_items' => $order->orderItems->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                    ];
                }),
            ];
        }),
    ]);
});

Route::get('/debug/schema', function () {
    return response()->json([
        'addresses_columns' => \DB::select("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'addresses' ORDER BY ORDINAL_POSITION"),
        'order_items_columns' => \DB::select("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'order_items' ORDER BY ORDINAL_POSITION"),
    ]);
});
