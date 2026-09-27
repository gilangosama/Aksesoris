<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$order = \App\Models\Order::with(['designInquiry.chainStyle', 'designInquiry.charms'])->whereNotNull('design_inquiry_id')->first();

if (!$order) {
    echo "No custom order found\n";
    exit(0);
}

echo "Order: " . $order->order_id . PHP_EOL;
if ($order->designInquiry) {
    echo "-- Reference: " . ($order->designInquiry->reference_design ?? 'none') . PHP_EOL;
    echo "-- Chain Style: " . ($order->designInquiry->chainStyle->name ?? 'none') . PHP_EOL;
    echo "-- Chain Image: " . ($order->designInquiry->chainStyle->image ?? 'none') . PHP_EOL;
    echo "-- Charms: " . ($order->designInquiry->charms->pluck('name')->join(', ') ?? 'none') . PHP_EOL;
    echo "-- Charm Images: " . ($order->designInquiry->charms->pluck('image')->join(', ') ?? 'none') . PHP_EOL;
} else {
    echo "No design inquiry?\n";
}
