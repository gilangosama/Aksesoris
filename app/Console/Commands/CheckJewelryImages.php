<?php

namespace App\Console\Commands;

use App\Models\CustomizableJewelry;
use Illuminate\Console\Command;

class CheckJewelryImages extends Command
{
    protected $signature = 'check:jewelry-images';
    protected $description = 'Check jewelry images in database and storage';

    public function handle(): int
    {
        $jewelry = CustomizableJewelry::all();

        $this->info('=== Customizable Jewelry Images Status ===');
        $this->newLine();

        foreach ($jewelry as $item) {
            $this->line("Type: {$item->type}");
            $this->line("Label: {$item->label}");
            $imageStatus = $item->image ? "✓ {$item->image}" : "✗ NULL";
            $this->line("Image: {$imageStatus}");
            
            if ($item->image) {
                $path = storage_path('app/public/' . $item->image);
                $exists = file_exists($path) ? '✓ EXISTS' : '✗ MISSING';
                $this->line("Status: {$exists}");
            }
            
            $this->newLine();
        }

        return 0;
    }
}
