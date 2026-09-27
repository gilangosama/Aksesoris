<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\CustomizableJewelry;

// Update the necklace with the image that exists in storage
$necklace = CustomizableJewelry::where('type', 'necklace')->first();
if ($necklace) {
    $necklace->update(['image' => 'jewelry-types/01KM23S6D8XY0YHSKKGBK8QW4B.png']);
    echo "Updated Necklace with image path\n";
}

// Show current status
echo "\nCurrent Status:\n";
$items = CustomizableJewelry::all();
foreach($items as $item) {
    echo $item->label . ": " . ($item->image ?: 'NO IMAGE') . "\n";
}
