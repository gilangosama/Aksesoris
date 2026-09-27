<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CHAIN STYLES ===\n";
$chainStyles = \App\Models\ChainStyle::limit(3)->get();
foreach ($chainStyles as $cs) {
    echo "ID: {$cs->id} | Name: {$cs->name} | Image: {$cs->image}\n";
}

echo "\n=== CHARMS (first 3) ===\n";
$charms = \App\Models\Charm::limit(3)->get();
foreach ($charms as $charm) {
    echo "ID: {$charm->id} | Name: {$charm->name} | Image: {$charm->image}\n";
}

echo "\n=== CHECK CUSTOM ORDER ===\n";
$order = \App\Models\Order::with(['designInquiry.chainStyle', 'designInquiry.charms'])->whereNotNull('design_inquiry_id')->first();
if ($order) {
    echo "Order: {$order->order_id}\n";
    echo "Chain Style ID: {$order->designInquiry->chain_style_id}\n";
    echo "Chain Style Image: {$order->designInquiry->chainStyle?->image}\n";
    echo "Charms: " . $order->designInquiry->charms->pluck('image')->join(', ') . "\n";
}
