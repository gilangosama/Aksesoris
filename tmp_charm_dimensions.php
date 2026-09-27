<?php
$img = 'storage/app/public/charms/01KMB2XFYC33YZE8Y99BZ3S4ST.png';
if (!file_exists($img)) {
    echo "FILE NOT FOUND: $img\n";
    exit(1);
}
$info = getimagesize($img);
var_export($info);
echo "\n";
$imgData = file_get_contents($img);
$bytes = strlen($imgData);
echo "size bytes: $bytes\n";
