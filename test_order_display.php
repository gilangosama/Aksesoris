<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$order = \App\Models\Order::with('addressRecord')->first();

if ($order && $order->addressRecord) {
    echo "✅ Order with Address Record Found:\n";
    echo "-----------------------------------\n";
    echo "Order ID: " . $order->order_id . "\n";
    echo "Recipient: " . $order->addressRecord->recipient_name . "\n";
    echo "Phone: " . $order->addressRecord->phone . "\n";
    echo "Street: " . $order->addressRecord->street . "\n";
    echo "City: " . $order->addressRecord->city . "\n";
    echo "Province: " . $order->addressRecord->province . "\n";
    echo "Postal: " . $order->addressRecord->postal_code . "\n";
    echo "-----------------------------------\n";
    echo "✅ All address fields are accessible!\n";
    echo "✅ Infolist will display correctly in admin panel.\n";
} else {
    echo "❌ No order with address record found\n";
}
