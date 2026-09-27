<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Order;

echo "=== Order Address Data Check ===\n\n";

$orders = Order::where('status', 'completed')
    ->with('addressRecord')
    ->latest()
    ->take(5)
    ->get();

echo "Total completed orders: " . $orders->count() . "\n\n";

if ($orders->count() > 0) {
    echo "Recent Completed Orders:\n";
    echo str_repeat("=", 100) . "\n";
    
    foreach ($orders as $order) {
        echo "\n📦 Order ID: {$order->order_id}\n";
        echo "   Customer: {$order->customer_name} ({$order->customer_email})\n";
        echo "   Phone: {$order->customer_phone}\n";
        echo "   Address Field: " . (empty($order->address) ? "❌ EMPTY" : "✓ " . substr($order->address, 0, 50) . "...") . "\n";
        
        if ($order->addressRecord) {
            echo "   Linked Address:\n";
            echo "     - Recipient: {$order->addressRecord->recipient_name}\n";
            echo "     - Phone: {$order->addressRecord->phone}\n";
            echo "     - Street: {$order->addressRecord->street}\n";
            echo "     - City: {$order->addressRecord->city}\n";
            echo "     - Province: {$order->addressRecord->province}\n";
            echo "     - Postal: {$order->addressRecord->postal_code}\n";
        } else {
            echo "   ⚠️  No linked address found for address_id: {$order->address_id}\n";
        }
    }
}

echo "\n";
