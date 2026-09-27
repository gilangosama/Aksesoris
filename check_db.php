<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\User;
use App\Models\Order;

echo "=== Database Check ===\n\n";

$users = User::all();
echo "Total Users: " . $users->count() . "\n";

if ($users->count() > 0) {
    echo "\nUsers:\n";
    foreach ($users as $user) {
        $orderCount = Order::where('user_id', $user->id)->count();
        echo "  - {$user->email}: {$user->name} (Orders: {$orderCount})\n";
    }
}

$orders = Order::latest()->take(5)->get();
echo "\nRecent Orders:\n";
if ($orders->count() > 0) {
    foreach ($orders as $order) {
        echo "  - {$order->order_id}: {$order->status} (Rp " . number_format($order->total_price, 0, '.', '.') . ")\n";
    }
} else {
    echo "  No orders found\n";
}

echo "\n";
