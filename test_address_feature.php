<?php
// Quick test untuk memverifikasi address feature implementation

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');

// Test 1: Check Address Model exists and has correct properties
echo "=== TEST 1: Address Model ===" . PHP_EOL;
try {
    $addressModel = new \App\Models\Address();
    echo "✓ Address model exists" . PHP_EOL;
    echo "  Fillable: " . implode(', ', $addressModel->getFillable()) . PHP_EOL;
} catch (\Exception $e) {
    echo "✗ Address model error: " . $e->getMessage() . PHP_EOL;
}

// Test 2: Check User model has relationships
echo "\n=== TEST 2: User Model Relationships ===" . PHP_EOL;
try {
    $user = new \App\Models\User();
    if (method_exists($user, 'addresses')) {
        echo "✓ User has addresses() relationship" . PHP_EOL;
    } else {
        echo "✗ User missing addresses() relationship" . PHP_EOL;
    }
    
    if (method_exists($user, 'defaultAddress')) {
        echo "✓ User has defaultAddress() relationship" . PHP_EOL;
    } else {
        echo "✗ User missing defaultAddress() relationship" . PHP_EOL;
    }
    
    $fillable = $user->getFillable();
    if (in_array('phone', $fillable)) {
        echo "✓ User has phone in fillable" . PHP_EOL;
    } else {
        echo "✗ User missing phone in fillable" . PHP_EOL;
    }
} catch (\Exception $e) {
    echo "✗ User model error: " . $e->getMessage() . PHP_EOL;
}

// Test 3: Check Order model has relationship and fields
echo "\n=== TEST 3: Order Model Updates ===" . PHP_EOL;
try {
    $order = new \App\Models\Order();
    if (method_exists($order, 'addressRecord')) {
        echo "✓ Order has addressRecord() relationship" . PHP_EOL;
    } else {
        echo "✗ Order missing addressRecord() relationship" . PHP_EOL;
    }
    
    $fillable = $order->getFillable();
    if (in_array('customer_phone', $fillable)) {
        echo "✓ Order has customer_phone in fillable" . PHP_EOL;
    } else {
        echo "✗ Order missing customer_phone in fillable" . PHP_EOL;
    }
    
    if (in_array('address_id', $fillable)) {
        echo "✓ Order has address_id in fillable" . PHP_EOL;
    } else {
        echo "✗ Order missing address_id in fillable" . PHP_EOL;
    }
} catch (\Exception $e) {
    echo "✗ Order model error: " . $e->getMessage() . PHP_EOL;
}

// Test 4: Check AddressController exists
echo "\n=== TEST 4: AddressController ===" . PHP_EOL;
try {
    $controller = new \App\Http\Controllers\AddressController();
    $methods = ['store', 'update', 'destroy', 'setDefault', 'list'];
    foreach ($methods as $method) {
        if (method_exists($controller, $method)) {
            echo "✓ AddressController has $method() method" . PHP_EOL;
        } else {
            echo "✗ AddressController missing $method() method" . PHP_EOL;
        }
    }
} catch (\Exception $e) {
    echo "✗ AddressController error: " . $e->getMessage() . PHP_EOL;
}

// Test 5: Check database tables via artisan command
echo "\n=== TEST 5: Database Structure ===" . PHP_EOL;
echo "Running: php artisan migrate:status" . PHP_EOL;
system('php artisan migrate:status | grep 2026_01_04');

echo "\n=== ALL TESTS COMPLETED ===" . PHP_EOL;
echo "Implementation Status: READY FOR TESTING" . PHP_EOL;
