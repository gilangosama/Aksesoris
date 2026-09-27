<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$order = \App\Models\Order::with(['designInquiry.chainStyle', 'designInquiry.charms'])->whereNotNull('design_inquiry_id')->first();
if (!$order) {
    echo "No custom order found\n";
    exit(1);
}

$inquiry = $order->designInquiry;
$chainImage = $inquiry?->chainStyle?->image;
$charms = $inquiry?->charms;

echo "Order " . $order->order_id . "\n";
echo "Reference: " . ($inquiry->reference_design ?: 'none') . "\n";
echo "Chain Image: " . ($chainImage ?: 'none') . "\n";

echo "Charms: " . ($charms->count() ?: '0') . "\n";
foreach ($charms as $charm) {
    echo " - {$charm->name}: {$charm->image}\n";
}

return 0;
