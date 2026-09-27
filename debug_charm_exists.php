<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$c = App\Models\Charm::find(1);
if(!$c){ echo "no charm1\n"; exit; }
$img = $c->image;
$file = public_path('storage/'.$img);
$valid = file_exists($file) ? 'exists' : 'no';

echo "charms 1 image={$img} path={$file} {$valid}\n";
