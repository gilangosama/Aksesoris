<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Populate chain styles with mock image paths
$chainStyles = [
    1 => 'chain-styles/silver-link-chain.jpg',
    2 => 'chain-styles/silver-rope-chain.jpg',
    3 => 'chain-styles/silver-figaro-chain.jpg',
    4 => 'chain-styles/gold-link-chain.jpg',
    5 => 'chain-styles/gold-rope-chain.jpg',
];

foreach ($chainStyles as $id => $imagePath) {
    \DB::table('chain_styles')->where('id', $id)->update(['image' => $imagePath]);
    echo "✅ ChainStyle {$id} updated with: {$imagePath}\n";
}

// Populate charms with mock image paths
$charms = [
    1 => 'charms/diamond-heart.jpg',
    2 => 'charms/diamond-clasp.jpg',
    3 => 'charms/pearl-accent.jpg',
    4 => 'charms/ruby-stone.jpg',
    5 => 'charms/emerald-drop.jpg',
];

foreach ($charms as $id => $imagePath) {
    \DB::table('charms')->where('id', $id)->update(['image' => $imagePath]);
    echo "✅ Charm {$id} updated with: {$imagePath}\n";
}

echo "\n=== Verification ===\n";
$order = \App\Models\Order::with(['designInquiry.chainStyle', 'designInquiry.charms'])->whereNotNull('design_inquiry_id')->first();
if ($order) {
    echo "Order: {$order->order_id}\n";
    echo "Chain Style Image: {$order->designInquiry->chainStyle?->image}\n";
    $charmImages = $order->designInquiry->charms->pluck('image')->toArray();
    echo "Charm Images: " . implode(', ', $charmImages) . "\n";
}
