<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CHECKING CURRENT CHAIN STYLES IMAGE DATA ===\n\n";

$chainStyles = \App\Models\ChainStyle::limit(5)->get();

foreach ($chainStyles as $cs) {
    echo "ID: {$cs->id} | Name: {$cs->name}\n";
    echo "  Image: " . ($cs->image ?: 'NULL') . "\n";
    echo "  Type: " . gettype($cs->image) . "\n\n";
}

echo "\n=== CHECK CUSTOM ORDER CHAIN STYLE ===\n";
$order = \App\Models\Order::with(['designInquiry.chainStyle'])->whereNotNull('design_inquiry_id')->first();
if ($order) {
    $chainStyle = $order->designInquiry->chainStyle;
    echo "Order: {$order->order_id}\n";
    echo "Chain Style: {$chainStyle->name}\n";
    echo "Chain Image: " . ($chainStyle->image ?: 'NULL - needs to be populated') . "\n";
}
