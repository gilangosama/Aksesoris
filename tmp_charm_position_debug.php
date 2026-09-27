<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$order = App\Models\Order::with(['designInquiry.chainStyle','designInquiry.charms'])->whereNotNull('design_inquiry_id')->first();
if (!$order) {
    echo "No order found\n";
    exit(1);
}
$inquiry = $order->designInquiry;
foreach ($inquiry->charms as $charm) {
    echo "charm {$charm->name}: x={$charm->pivot->charm_position_x}, y={$charm->pivot->charm_position_y}, image={$charm->image}\n";
}
