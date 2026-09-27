<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use Midtrans\Snap;
use Midtrans\Config;

echo "=== Midtrans Configuration Test ===\n\n";

// Load config
$serverKey = config('midtrans.midtrans.server_key');
$clientKey = config('midtrans.midtrans.client_key');
$isProduction = config('midtrans.midtrans.is_production');

echo "Server Key: " . (empty($serverKey) ? "❌ NOT SET" : "✓ " . substr($serverKey, 0, 10) . "...") . "\n";
echo "Client Key: " . (empty($clientKey) ? "❌ NOT SET" : "✓ " . substr($clientKey, 0, 10) . "...") . "\n";
echo "Is Production: " . ($isProduction ? "true" : "false") . "\n\n";

if (empty($serverKey) || empty($clientKey)) {
    echo "❌ ERROR: Midtrans configuration incomplete!\n";
    exit(1);
}

// Configure Midtrans
Config::$serverKey = $serverKey;
Config::$clientKey = $clientKey;
Config::$isProduction = $isProduction;
Config::$isSanitized = true;
Config::$is3ds = true;

echo "=== Testing Snap Token Generation ===\n\n";

try {
    $params = [
        'transaction_details' => [
            'order_id' => 'TEST-' . time(),
            'gross_amount' => 100000,
        ],
        'customer_details' => [
            'first_name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '08123456789',
        ],
        'item_details' => [
            [
                'id' => 'TEST-ITEM',
                'price' => 100000,
                'quantity' => 1,
                'name' => 'Test Item'
            ]
        ],
    ];

    echo "Payload:\n";
    echo json_encode($params, JSON_PRETTY_PRINT) . "\n\n";

    $snapToken = Snap::getSnapToken($params);

    if (!$snapToken) {
        echo "❌ ERROR: Snap token is empty/null\n";
        echo "Response: " . var_export($snapToken, true) . "\n";
        exit(1);
    }

    if (!is_string($snapToken)) {
        echo "❌ ERROR: Snap token is not string\n";
        echo "Type: " . gettype($snapToken) . "\n";
        echo "Value: " . var_export($snapToken, true) . "\n";
        exit(1);
    }

    echo "✓ Snap Token Generated Successfully!\n";
    echo "Token (first 50 chars): " . substr($snapToken, 0, 50) . "...\n";
    echo "Token Length: " . strlen($snapToken) . "\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    exit(1);
}

echo "\n✓ All tests passed!\n";
exit(0);
