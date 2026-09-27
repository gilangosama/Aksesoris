<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Charm;

// Category mapping based on charm names
$categoryMap = [
    'diamond' => 'diamonds',
    'pearl' => 'pearls',
    'crystal' => 'crystals',
    'gemstone' => 'gemstones',
    'gold' => 'metal',
    'tag' => 'metal',
    'connector' => 'metal',
];

$charms = Charm::all();

foreach ($charms as $charm) {
    // Set stock to 999 if not already set
    if (!$charm->stock || $charm->stock == 0) {
        $charm->stock = 999;
    }
    
    // Determine category based on charm name
    $category = 'other';
    $nameLower = strtolower($charm->name);
    
    foreach ($categoryMap as $keyword => $cat) {
        if (strpos($nameLower, $keyword) !== false) {
            $category = $cat;
            break;
        }
    }
    
    $charm->category = $category;
    $charm->save();
    
    echo "Updated: {$charm->name} -> Category: {$category}, Stock: {$charm->stock}\n";
}

echo "\nAll charms updated successfully!\n";
