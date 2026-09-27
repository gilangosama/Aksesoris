<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\CustomizableJewelry;

$items = CustomizableJewelry::all();
echo "Jewelry Types and Images:\n";
echo str_repeat("=", 50) . "\n";

foreach($items as $item) {
    $image = $item->image ?: 'NULL';
    echo $item->label . ": " . $image . "\n";
}

echo "\n\nStorage path check:\n";
$storagePath = storage_path('app/public/jewelry-types');
if (is_dir($storagePath)) {
    $files = array_diff(scandir($storagePath), ['.', '..']);
    echo "Files in jewelry-types/:\n";
    foreach($files as $file) {
        echo "  - " . $file . "\n";
    }
} else {
    echo "Directory does not exist: " . $storagePath . "\n";
}
