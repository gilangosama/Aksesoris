<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CHARM DEBUG ===\n\n";

// Get order dengan design inquiry
$order = App\Models\Order::with(['designInquiry.chainStyle','designInquiry.charms'])->whereNotNull('design_inquiry_id')->first();
if (!$order) {
    echo "❌ No custom order found\n";
    exit(1);
}

$inquiry = $order->designInquiry;
echo "Order: {$order->order_id}\n";
echo "Inquiry ID: {$inquiry->id}\n\n";

// Check chain
echo "CHAIN:\n";
if ($inquiry->chainStyle) {
    $chain = $inquiry->chainStyle;
    echo "  Name: {$chain->name}\n";
    echo "  Image: {$chain->image}\n";
    $chainPath = "storage/app/public/{$chain->image}";
    echo "  Path: $chainPath\n";
    echo "  Exists: " . (file_exists($chainPath) ? "✅ YES" : "❌ NO") . "\n";
} else {
    echo "  ❌ No chain style\n";
}

echo "\nCHARMS:\n";
if ($inquiry->charms->count() > 0) {
    foreach ($inquiry->charms as $idx => $charm) {
        echo "  [{$idx}] {$charm->name}\n";
        echo "      Image: {$charm->image}\n";
        echo "      Position: x={$charm->pivot->charm_position_x}, y={$charm->pivot->charm_position_y}\n";
        $charmPath = "storage/app/public/{$charm->image}";
        echo "      Path: $charmPath\n";
        echo "      Exists: " . (file_exists($charmPath) ? "✅ YES" : "❌ NO") . "\n";
    }
} else {
    echo "  ❌ No charms attached\n";
}

echo "\nDESIGN_SNAPSHOT:\n";
echo "  Length: " . strlen($inquiry->design_snapshot) . " bytes\n";
echo "  Is NULL: " . (is_null($inquiry->design_snapshot) ? "YES" : "NO") . "\n";
echo "  Is Empty String: " . (empty($inquiry->design_snapshot) ? "YES" : "NO") . "\n";
if ($inquiry->design_snapshot) {
    echo "  Prefix: " . substr($inquiry->design_snapshot, 0, 80) . "...\n";
}
