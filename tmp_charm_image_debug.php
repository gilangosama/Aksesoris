<?php
require 'vendor/autoload.php';
$app=require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$c=App\Models\Charm::first();
if(!$c){echo "no charm\n"; exit(1);} 
var_export(['name'=>$c->name,'image'=>$c->image]);
echo "\n";
