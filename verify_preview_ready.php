<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CUSTOM DESIGN IMAGE PREVIEW READY ===\n\n";

$order = \App\Models\Order::with(['designInquiry.chainStyle', 'designInquiry.charms'])->whereNotNull('design_inquiry_id')->first();

if ($order) {
    echo "✅ Custom Order Found\n";
    echo "   Order ID: {$order->order_id}\n";
    echo "   Order Date: {$order->created_at}\n";
    
    $inquiry = $order->designInquiry;
    
    if ($inquiry) {
        echo "\n✅ Design Inquiry Found\n";
        echo "   Design Type: {$inquiry->type}\n";
        
        if ($inquiry->chainStyle) {
            echo "\n✅ Chain Style Found\n";
            echo "   Name: {$inquiry->chainStyle->name}\n";
            echo "   Image URL: " . (substr($inquiry->chainStyle->image, 0, 60)) . "...\n";
        }
        
        if ($inquiry->charms->count()) {
            echo "\n✅ Charms Found: {$inquiry->charms->count()}\n";
            foreach ($inquiry->charms as $charm) {
                echo "   • {$charm->name}\n";
                echo "     Image: " . (substr($charm->image, 0, 60)) . "...\n";
            }
        }
        
        echo "\n✅ READY FOR ADMIN VIEW\n";
        echo "   Navigate to Admin Panel → Orders → View this order\n";
        echo "   You should see:\n";
        echo "   1. Chain style image with download button\n";
        echo "   2. Charms grid with individual images and download buttons\n";
    }
} else {
    echo "❌ No custom order found\n";
}
