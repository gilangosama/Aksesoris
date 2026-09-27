<?php

namespace Database\Seeders;

use App\Models\ChainStyle;
use App\Models\CustomizableJewelry;
use Illuminate\Database\Seeder;

class ChainStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get jewelry types
        $necklace = CustomizableJewelry::where('type', 'necklace')->first();
        $bracelet = CustomizableJewelry::where('type', 'bracelet')->first();
        $handChain = CustomizableJewelry::where('type', 'hand_chain')->first();
        $earring = CustomizableJewelry::where('type', 'earring')->first();

        // Necklace chain styles
        if ($necklace) {
            $necklaceChains = [
                [
                    'customizable_jewelry_id' => $necklace->id,
                    'name' => 'Silver Link Chain',
                    'finish' => 'silver',
                    'description' => 'Classic interlocking links for a timeless look',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $necklace->id,
                    'name' => 'Silver Rope Chain',
                    'finish' => 'silver',
                    'description' => 'Twisted rope design with elegant sophistication',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $necklace->id,
                    'name' => 'Silver Figaro Chain',
                    'finish' => 'silver',
                    'description' => 'Mixed link pattern for a unique style',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $necklace->id,
                    'name' => 'Silver Box Chain',
                    'finish' => 'silver',
                    'description' => 'Square links creating a smooth, polished appearance',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $necklace->id,
                    'name' => 'Gold Link Chain',
                    'finish' => 'gold',
                    'description' => 'Classic interlocking links for a timeless look',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $necklace->id,
                    'name' => 'Gold Rope Chain',
                    'finish' => 'gold',
                    'description' => 'Twisted rope design with elegant sophistication',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $necklace->id,
                    'name' => 'Gold Figaro Chain',
                    'finish' => 'gold',
                    'description' => 'Mixed link pattern for a unique style',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $necklace->id,
                    'name' => 'Gold Box Chain',
                    'finish' => 'gold',
                    'description' => 'Square links creating a smooth, polished appearance',
                    'is_active' => true,
                ],
            ];

            foreach ($necklaceChains as $chain) {
                ChainStyle::updateOrCreate(
                    [
                        'customizable_jewelry_id' => $chain['customizable_jewelry_id'],
                        'name' => $chain['name'],
                        'finish' => $chain['finish']
                    ],
                    $chain
                );
            }
        }

        // Bracelet chain styles
        if ($bracelet) {
            $braceletChains = [
                [
                    'customizable_jewelry_id' => $bracelet->id,
                    'name' => 'Silver Thin Link',
                    'finish' => 'silver',
                    'description' => 'Delicate thin link design perfect for bracelets',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $bracelet->id,
                    'name' => 'Silver Cuban Chain',
                    'finish' => 'silver',
                    'description' => 'Sturdy Cuban link for a bold statement',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $bracelet->id,
                    'name' => 'Gold Thin Link',
                    'finish' => 'gold',
                    'description' => 'Delicate thin link design perfect for bracelets',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $bracelet->id,
                    'name' => 'Gold Cuban Chain',
                    'finish' => 'gold',
                    'description' => 'Sturdy Cuban link for a bold statement',
                    'is_active' => true,
                ],
            ];

            foreach ($braceletChains as $chain) {
                ChainStyle::updateOrCreate(
                    [
                        'customizable_jewelry_id' => $chain['customizable_jewelry_id'],
                        'name' => $chain['name'],
                        'finish' => $chain['finish']
                    ],
                    $chain
                );
            }
        }

        // Hand chain styles
        if ($handChain) {
            $handChainStyles = [
                [
                    'customizable_jewelry_id' => $handChain->id,
                    'name' => 'Silver Elegant Link',
                    'finish' => 'silver',
                    'description' => 'Elegant linked design for hand chains',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $handChain->id,
                    'name' => 'Silver Pearl Chain',
                    'finish' => 'silver',
                    'description' => 'Chain with pearl accent details',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $handChain->id,
                    'name' => 'Gold Elegant Link',
                    'finish' => 'gold',
                    'description' => 'Elegant linked design for hand chains',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $handChain->id,
                    'name' => 'Gold Pearl Chain',
                    'finish' => 'gold',
                    'description' => 'Chain with pearl accent details',
                    'is_active' => true,
                ],
            ];

            foreach ($handChainStyles as $chain) {
                ChainStyle::updateOrCreate(
                    [
                        'customizable_jewelry_id' => $chain['customizable_jewelry_id'],
                        'name' => $chain['name'],
                        'finish' => $chain['finish']
                    ],
                    $chain
                );
            }
        }

        // Earring styles
        if ($earring) {
            $earringStyles = [
                [
                    'customizable_jewelry_id' => $earring->id,
                    'name' => 'Silver Stud Setting',
                    'finish' => 'silver',
                    'description' => 'Classic stud earring setting',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $earring->id,
                    'name' => 'Silver Drop Setting',
                    'finish' => 'silver',
                    'description' => 'Elegant drop earring setting',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $earring->id,
                    'name' => 'Gold Stud Setting',
                    'finish' => 'gold',
                    'description' => 'Classic stud earring setting',
                    'is_active' => true,
                ],
                [
                    'customizable_jewelry_id' => $earring->id,
                    'name' => 'Gold Drop Setting',
                    'finish' => 'gold',
                    'description' => 'Elegant drop earring setting',
                    'is_active' => true,
                ],
            ];

            foreach ($earringStyles as $chain) {
                ChainStyle::updateOrCreate(
                    [
                        'customizable_jewelry_id' => $chain['customizable_jewelry_id'],
                        'name' => $chain['name'],
                        'finish' => $chain['finish']
                    ],
                    $chain
                );
            }
        }
    }
}
