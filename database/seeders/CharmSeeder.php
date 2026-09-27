<?php

namespace Database\Seeders;

use App\Models\Charm;
use Illuminate\Database\Seeder;

class CharmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Universal charms available for all jewelry types
        $universalCharms = [
            // Diamond options
            [
                'name' => 'Diamond Heart',
                'description' => 'Elegant heart-shaped diamond pendant',
                'price_add' => 50.00,
                'is_active' => true,
            ],
            [
                'name' => 'Diamond Clasp',
                'description' => 'Diamond-studded clasp accent',
                'price_add' => 60.00,
                'is_active' => true,
            ],
            // Pearl options
            [
                'name' => 'Pearl Accent',
                'description' => 'Classic pearl pendant accent',
                'price_add' => 30.00,
                'is_active' => true,
            ],
            [
                'name' => 'Pearl Drop',
                'description' => 'Elegant pearl drop charm',
                'price_add' => 20.00,
                'is_active' => true,
            ],
            [
                'name' => 'Pearl End',
                'description' => 'Pearl accent at the end',
                'price_add' => 25.00,
                'is_active' => true,
            ],
            // Crystal options
            [
                'name' => 'Crystal Bead',
                'description' => 'Sparkling crystal bead charm',
                'price_add' => 25.00,
                'is_active' => true,
            ],
            [
                'name' => 'Crystal Cluster',
                'description' => 'Multiple crystal cluster accent',
                'price_add' => 30.00,
                'is_active' => true,
            ],
            // Gemstone options
            [
                'name' => 'Gemstone Drop',
                'description' => 'Colorful gemstone drop pendant',
                'price_add' => 40.00,
                'is_active' => true,
            ],
            [
                'name' => 'Gemstone Charm',
                'description' => 'Colorful gemstone charm accent',
                'price_add' => 30.00,
                'is_active' => true,
            ],
            [
                'name' => 'Gemstone Center',
                'description' => 'Gemstone centered pendant',
                'price_add' => 35.00,
                'is_active' => true,
            ],
            // Gold options
            [
                'name' => 'Gold Tag',
                'description' => 'Personalized gold name tag charm',
                'price_add' => 35.00,
                'is_active' => true,
            ],
            // Ring & connector options
            [
                'name' => 'Ring Connector',
                'description' => 'Connects to ring for hand chain elegance',
                'price_add' => 40.00,
                'is_active' => true,
            ],
            // Plain/None options
            [
                'name' => 'None - Plain Chain',
                'description' => 'No pendant, just the chain',
                'price_add' => 0.00,
                'is_active' => true,
            ],
            [
                'name' => 'None - Plain',
                'description' => 'No charm, just the base item',
                'price_add' => 0.00,
                'is_active' => true,
            ],
            [
                'name' => 'Plain Setting',
                'description' => 'Plain setting without additional accent',
                'price_add' => 0.00,
                'is_active' => true,
            ],
        ];

        // Create all universal charms
        foreach ($universalCharms as $charm) {
            Charm::updateOrCreate(
                ['name' => $charm['name']],
                $charm
            );
        }
    }
}
