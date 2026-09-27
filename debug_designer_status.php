<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$i = App\Models\DesignInquiry::with(['charms','chainStyle'])->whereNotNull('design_snapshot')->first();
if(!$i) {
    echo "no snapshot found\n";
    exit;
}

echo "id={$i->id} charms={$i->charms->count()} chainStyle={$i->chainStyle->name}\n";
echo "snapshot len=".strlen($i->design_snapshot)."\n";

echo "charm positions:\n";
foreach($i->charms as $c) {
    echo "- {$c->id} {$c->name} x={$c->pivot->charm_position_x} y={$c->pivot->charm_position_y}\n";
}
