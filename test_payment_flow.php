<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\User;
use App\Models\DesignInquiry;
use App\Models\Order;

echo "=== Testing Custom Design Payment Flow ===\n\n";

// Find or create test user
$user = User::where('email', 'test@example.com')->first();
if (!$user) {
    echo "❌ Test user not found. Create user first:\n";
    echo "php artisan tinker\n";
    echo "User::create(['name' => 'Test', 'email' => 'test@example.com', 'password' => bcrypt('password')])\n";
    exit(1);
}

echo "✓ Test user: {$user->name} ({$user->email})\n";

// Create test address
$address = $user->addresses()->firstOrCreate([
    'street' => 'Test Street 123',
    'city' => 'Test City',
    'province' => 'Test Province',
    'postal_code' => '12345',
], [
    'recipient_name' => $user->name,
    'phone' => '08123456789',
    'is_default' => true,
]);

echo "✓ Test address: {$address->recipient_name}, {$address->city}\n\n";

// Get or create test design inquiry
$inquiry = DesignInquiry::where('user_id', $user->id)->first();
if (!$inquiry) {
    echo "❌ Design inquiry not found. Create one first via UI or:\n";
    echo "php artisan tinker\n";
    echo "DesignInquiry::create(['user_id' => {$user->id}, ...])\n";
    exit(1);
}

echo "✓ Design inquiry: {$inquiry->type} ({$inquiry->finish})\n";
echo "  Chain style: {$inquiry->chainStyle?->name}\n";
echo "  Charms: " . $inquiry->charms->count() . "\n\n";

// Calculate total price
$totalPrice = $inquiry->charms->sum('price_add') ?? 100000;
if ($totalPrice < 10000) {
    $totalPrice = 100000;
}

echo "=== Simulating Payment Request ===\n\n";
echo "Total: Rp " . number_format($totalPrice, 0, '.', '.') . "\n";
echo "Address ID: {$address->id}\n";
echo "Inquiry ID: {$inquiry->id}\n\n";

// Check if order already exists for this inquiry
$existingOrder = Order::where('design_inquiry_id', $inquiry->id)->latest()->first();
if ($existingOrder) {
    echo "⚠️  Existing order found:\n";
    echo "   Order ID: {$existingOrder->order_id}\n";
    echo "   Status: {$existingOrder->status}\n";
    echo "   Snap Token: " . (empty($existingOrder->snap_token) ? "Not set" : "✓ Set") . "\n";
    echo "   Amount: Rp " . number_format($existingOrder->total_price, 0, '.', '.') . "\n\n";
}

echo "To test the payment flow via POST request:\n";
echo "1. Get CSRF token from page\n";
echo "2. Send POST to /checkout/custom-design/{$inquiry->id}/pay\n";
echo "3. With JSON body:\n";
echo json_encode([
    'address_id' => $address->id,
    'total_price' => $totalPrice,
    'is_gift' => false,
    'gift_message' => '',
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n\n";

echo "✓ Test data ready!\n";
exit(0);
