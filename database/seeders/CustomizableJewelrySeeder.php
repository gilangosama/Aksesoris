<?php

namespace Database\Seeders;

use App\Models\CustomizableJewelry;
use Illuminate\Database\Seeder;

class CustomizableJewelrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jewelry = [
            [
                'type' => 'necklace',
                'label' => 'Necklace',
                'icon' => '📿',
                'image' => null,
                'description' => 'Classic necklaces for everyday elegance',
                'base_price' => 3750000,
                'is_active' => true,
            ],
            [
                'type' => 'bracelet',
                'label' => 'Bracelet',
                'icon' => '⌚',
                'image' => null,
                'description' => 'Stylish bracelets for your wrist',
                'base_price' => 3750000,
                'is_active' => true,
            ],
            [
                'type' => 'hand_chain',
                'label' => 'Hand Chain',
                'icon' => '✋',
                'image' => null,
                'description' => 'Unique hand chains connecting wrist to fingers',
                'base_price' => 3750000,
                'is_active' => true,
            ],
            [
                'type' => 'earring',
                'label' => 'Earrings',
                'icon' => '💎',
                'image' => null,
                'description' => 'Beautiful earrings to complete your look',
                'base_price' => 3750000,
                'is_active' => true,
            ],
            [
                'type' => 'keychain',
                'label' => 'Keychain',
                'icon' => '🔑',
                'image' => null,
                'description' => 'Custom keychains to carry your style everywhere',
                'base_price' => 3750000,
                'is_active' => true,
            ],
        ];

        foreach ($jewelry as $item) {
            CustomizableJewelry::updateOrCreate(
                ['type' => $item['type']],
                $item
            );
        }
    }
}
