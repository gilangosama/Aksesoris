<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Order;

echo "=== Populate Address Field for Existing Orders ===\n\n";

$orders = Order::whereNull('address')
    ->orWhere('address', '')
    ->with('addressRecord')
    ->get();

echo "Orders with empty address: " . $orders->count() . "\n\n";

if ($orders->count() > 0) {
    $updated = 0;
    foreach ($orders as $order) {
        if ($order->addressRecord) {
            $order->address = "{$order->addressRecord->recipient_name}, {$order->addressRecord->street}, {$order->addressRecord->city}, {$order->addressRecord->province} {$order->addressRecord->postal_code}";
            $order->save();
            $updated++;
            echo "✓ Updated: {$order->order_id}\n";
        }
    }
    echo "\n✓ Successfully updated {$updated} orders!\n";
} else {
    echo "✓ All orders already have address data!\n";
}

echo "\n";
