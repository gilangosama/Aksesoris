<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Update dengan placeholder image URLs
$chainStylePlaceholders = [
    1 => 'https://placehold.co/200x200/c0c0c0/666?text=Silver+Link+Chain',
    2 => 'https://placehold.co/200x200/c0c0c0/666?text=Silver+Rope+Chain',
    3 => 'https://placehold.co/200x200/c0c0c0/666?text=Silver+Figaro+Chain',
    4 => 'https://placehold.co/200x200/ffd700/333?text=Gold+Link+Chain',
    5 => 'https://placehold.co/200x200/ffd700/333?text=Gold+Rope+Chain',
];

foreach ($chainStylePlaceholders as $id => $url) {
    \DB::table('chain_styles')->where('id', $id)->update(['image' => $url]);
    echo "✅ ChainStyle {$id} updated\n";
}

// Update charms dengan placeholder URLs
$charmPlaceholders = [
    1 => 'https://placehold.co/120x120/e91e63/fff?text=Diamond+Heart',
    2 => 'https://placehold.co/120x120/e91e63/fff?text=Diamond+Clasp',
    3 => 'https://placehold.co/120x120/fff8dc/333?text=Pearl+Accent',
    4 => 'https://placehold.co/120x120/c41e3a/fff?text=Ruby+Stone',
    5 => 'https://placehold.co/120x120/50c878/fff?text=Emerald+Drop',
];

foreach ($charmPlaceholders as $id => $url) {
    \DB::table('charms')->where('id', $id)->update(['image' => $url]);
    echo "✅ Charm {$id} updated\n";
}

echo "\n=== Verification ===\n";

$chainStyle = \App\Models\ChainStyle::find(5);
echo "Chain Style Image: " . ($chainStyle->image ? "✅ " . substr($chainStyle->image, 0, 50) . "..." : "❌ None") . "\n";

$charm = \App\Models\Charm::find(1);
echo "Charm Image: " . ($charm->image ? "✅ " . substr($charm->image, 0, 50) . "..." : "❌ None") . "\n";

echo "\n✅ All image URLs populated! Ready for preview in admin.\n";
