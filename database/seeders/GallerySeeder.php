<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleryItems = [
            [
                'image_url' => '/images/products/1.jpg',
                'title' => 'Elegance',
                'description' => 'Discover More',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'image_url' => '/images/products/2.jpg',
                'title' => 'Pearl Rings',
                'description' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'image_url' => '/images/products/3.jpg',
                'title' => 'Luxury Stones',
                'description' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'image_url' => '/images/products/4.jpg',
                'title' => 'Bracelets',
                'description' => null,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'image_url' => '/images/products/1.jpg',
                'title' => 'Timeless',
                'description' => null,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'image_url' => '/images/products/2.jpg',
                'title' => 'New Collection',
                'description' => 'Explore Now',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'image_url' => '/images/products/3.jpg',
                'title' => 'Radiance',
                'description' => null,
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'image_url' => '/images/products/4.jpg',
                'title' => 'Heritage',
                'description' => null,
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($galleryItems as $item) {
            Gallery::create($item);
        }
    }
}
