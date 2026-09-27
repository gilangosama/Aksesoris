<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Rings',
                'slug' => 'rings',
                'description' => 'Elegant rings for every occasion',
                'image' => '/images/categories/rings.jpg',
            ],
            [
                'name' => 'Necklaces',
                'slug' => 'necklaces',
                'description' => 'Beautiful necklaces and chains',
                'image' => '/images/categories/necklaces.jpg',
            ],
            [
                'name' => 'Bracelets',
                'slug' => 'bracelets',
                'description' => 'Stylish bracelets and bangles',
                'image' => '/images/categories/bracelets.jpg',
            ],
            [
                'name' => 'Earrings',
                'slug' => 'earrings',
                'description' => 'Exquisite earrings collection',
                'image' => '/images/categories/earrings.jpg',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
