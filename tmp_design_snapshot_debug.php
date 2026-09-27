<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$order = App\Models\Order::with(['designInquiry.chainStyle','designInquiry.charms'])->whereNotNull('design_inquiry_id')->first();
if (!$order) {
    echo "No order\n";
    exit(1);
}
$inquiry = $order->designInquiry;
echo "order id: {$order->order_id}\n";
echo "design_snapshot length: " . strlen($inquiry->design_snapshot) . "\n";
echo "prefix: " . substr($inquiry->design_snapshot, 0, 120) . "\n";
