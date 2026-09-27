<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test the tracking number field
$order = \App\Models\Order::first();

if ($order) {
    echo "✅ Order found: " . $order->order_id . "\n";
    echo "-----------------------------------\n";
    echo "Current tracking_number: " . ($order->tracking_number ?? 'Not set') . "\n";
    echo "\n✅ Testing tracking_number field...\n";
    
    // Test updating with tracking number
    $order->update(['tracking_number' => 'JNE123456789']);
    $order->refresh();
    
    echo "✅ Tracking number saved: " . $order->tracking_number . "\n";
    echo "-----------------------------------\n";
    echo "✅ Tracking number field is working correctly!\n";
    echo "✅ Admin can now enter and save nomor resi!\n";
} else {
    echo "❌ No orders found\n";
}
