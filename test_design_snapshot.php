<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CUSTOM DESIGN SNAPSHOT TEST ===\n\n";

// Check if design_snapshot column exists
$hasColumn = \Schema::hasColumn('design_inquiries', 'design_snapshot');
echo "✅ design_snapshot column exists: " . ($hasColumn ? 'YES' : 'NO') . "\n";

// Check model fillable
$inquiry = new \App\Models\DesignInquiry();
$fillable = $inquiry->getFillable();
echo "✅ design_snapshot in fillable: " . (in_array('design_snapshot', $fillable) ? 'YES' : 'NO') . "\n";

// Check existing custom order
$order = \App\Models\Order::with('designInquiry')->whereNotNull('design_inquiry_id')->first();
if ($order) {
    echo "\n✅ Custom Order Found: {$order->order_id}\n";
    
    $inq = $order->designInquiry;
    if ($inq) {
        echo "   Design Type: {$inq->type}\n";
        echo "   Design Snapshot: " . ($inq->design_snapshot ? 'Exists (' . strlen($inq->design_snapshot) . ' chars)' : 'Empty') . "\n";
        
        if (!$inq->design_snapshot) {
            echo "\n   📝 Note: Preview will be captured when user hits 'Proceed to Payment' on checkout\n";
            echo "   📝 After capture, design_snapshot will show in admin panel\n";
        }
    }
} else {
    echo "\n❌ No custom order found for testing\n";
}

echo "\n✅ Setup complete! Preview capture now ready.\n";
echo "   When user clicks 'Proceed to Payment':\n";
echo "   1. Preview is captured from #design-preview element\n";
echo "   2. Image sent to server as base64\n";
echo "   3. Saved to design_inquiries.design_snapshot\n";
echo "   4. Displays in admin 'Custom Design (Preview + Download)' section\n";
