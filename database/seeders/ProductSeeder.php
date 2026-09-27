<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');

        $productsData = [
            [
                'name' => 'Pearl Elegance Ring',
                'description' => 'Timeless pearl ring with 18K gold finish',
                'price' => 4275000,
                'original_price' => null,
                'category_id' => $categories['rings']->id,
                'sku' => 'RING-001',
                'stock' => 5,
                'image' => '/images/products/1.jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'Rose Gold Necklace',
                'description' => 'Delicate rose gold pendant necklace',
                'price' => 5775000,
                'original_price' => 6750000,
                'category_id' => $categories['necklaces']->id,
                'sku' => 'NECK-001',
                'stock' => 3,
                'image' => '/images/products/2.jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'Crystal Bracelet',
                'description' => 'Sparkling crystal and silver bracelet',
                'price' => 2925000,
                'original_price' => null,
                'category_id' => $categories['bracelets']->id,
                'sku' => 'BRAC-001',
                'stock' => 8,
                'image' => '/images/products/3.jpg',
                'is_featured' => false,
            ],
            [
                'name' => 'Custom Earrings',
                'description' => 'Bespoke design earrings',
                'price' => 1875000,
                'original_price' => null,
                'category_id' => $categories['earrings']->id,
                'sku' => 'EAR-001',
                'stock' => 10,
                'image' => '/images/products/4.jpg',
                'is_featured' => false,
            ],
            [
                'name' => 'Diamond Promise Ring',
                'description' => 'Elegant diamond solitaire ring',
                'price' => 8985000,
                'original_price' => 10485000,
                'category_id' => $categories['rings']->id,
                'sku' => 'RING-002',
                'stock' => 2,
                'image' => '/images/products/1.jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'Vintage Gold Chain',
                'description' => 'Classic vintage gold chain necklace',
                'price' => 3675000,
                'original_price' => null,
                'category_id' => $categories['necklaces']->id,
                'sku' => 'NECK-002',
                'stock' => 4,
                'image' => '/images/products/2.jpg',
                'is_featured' => false,
            ],
            [
                'name' => 'Pearl Bracelet Set',
                'description' => 'Beautiful pearl bracelet collection',
                'price' => 4875000,
                'original_price' => null,
                'category_id' => $categories['bracelets']->id,
                'sku' => 'BRAC-002',
                'stock' => 6,
                'image' => '/images/products/3.jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'Diamond Drop Earrings',
                'description' => 'Exquisite diamond drop earrings',
                'price' => 6750000,
                'original_price' => 7875000,
                'category_id' => $categories['earrings']->id,
                'sku' => 'EAR-002',
                'stock' => 3,
                'image' => '/images/products/4.jpg',
                'is_featured' => true,
            ],
            [
                'name' => 'Sapphire Ring',
                'description' => 'Stunning sapphire with gold band',
                'price' => 7800000,
                'original_price' => null,
                'category_id' => $categories['rings']->id,
                'sku' => 'RING-003',
                'stock' => 2,
                'image' => '/images/products/1.jpg',
                'is_featured' => false,
            ],
            [
                'name' => 'Lace Pendant',
                'description' => 'Delicate lace-inspired pendant',
                'price' => 2625000,
                'original_price' => null,
                'category_id' => $categories['necklaces']->id,
                'sku' => 'NECK-003',
                'stock' => 7,
                'image' => '/images/products/2.jpg',
                'is_featured' => false,
            ],
            [
                'name' => 'Gold Bangle',
                'description' => 'Classic gold bangle bracelet',
                'price' => 4200000,
                'original_price' => null,
                'category_id' => $categories['bracelets']->id,
                'sku' => 'BRAC-003',
                'stock' => 5,
                'image' => '/images/products/3.jpg',
                'is_featured' => false,
            ],
            [
                'name' => 'Pearl Stud Earrings',
                'description' => 'Classic pearl stud earrings',
                'price' => 2325000,
                'original_price' => null,
                'category_id' => $categories['earrings']->id,
                'sku' => 'EAR-003',
                'stock' => 9,
                'image' => '/images/products/4.jpg',
                'is_featured' => false,
            ],
        ];

        foreach ($productsData as $product) {
            $product['slug'] = Str::slug($product['name']);
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
}
