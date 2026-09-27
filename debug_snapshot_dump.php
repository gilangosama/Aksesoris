<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$i = App\Models\DesignInquiry::find(11);
if (!$i || !$i->design_snapshot) { echo "no design_snapshot\n"; exit; }

$base64 = $i->design_snapshot;
if (strpos($base64, 'base64,') !== false) {
    $base64 = explode('base64,', $base64, 2)[1];
}
$data = base64_decode($base64);
if (!$data) { echo "decode fail\n"; exit; }

$file = __DIR__.'/debug_snapshot.png';
file_put_contents($file, $data);
echo "dumped to $file, size=".filesize($file)."\n";
