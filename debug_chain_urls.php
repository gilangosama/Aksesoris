<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CHAIN IMAGE URL DEBUG ===\n\n";

$chainStyles = \App\Models\ChainStyle::whereNotNull('image')->get();

foreach ($chainStyles as $cs) {
    $imagePath = $cs->image;
    
    // Check if it's URL or relative path
    $isUrl = filter_var($imagePath, FILTER_VALIDATE_URL);
    
    echo "ID: {$cs->id} | Name: {$cs->name}\n";
    echo "  Raw image: {$imagePath}\n";
    echo "  Is URL: " . ($isUrl ? 'YES' : 'NO') . "\n";
    
    // Generate asset URL (what Blade would generate)
    if ($isUrl) {
        $assetUrl = $imagePath;
    } else {
        $assetUrl = asset('storage/' . $imagePath);
    }
    
    echo "  Asset URL: {$assetUrl}\n";
    
    // Check if file exists
    if (!$isUrl && strpos($imagePath, 'placehold') === false) {
        $filePath = storage_path('app/public/' . $imagePath);
        $fileExists = file_exists($filePath);
        echo "  File exists: " . ($fileExists ? '✅ YES' : '❌ NO') . "\n";
        if ($fileExists) {
            echo "  File size: " . (filesize($filePath) / 1024) . " KB\n";
        }
    }
    
    echo "\n";
}

echo "=== SUMMARY ===\n";
echo "URL Format used: asset('storage/' . \$path)\n";
echo "This should generate URLs like: /storage/chain-styles/filename.ext\n";
