<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display products by category with filters & sorting
     */
    public function show($slug, Request $request)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $query = Product::where('category_id', $category->id)
            ->where('is_active', true);

        // Price Range Filter
        if ($request->has('price_range') && $request->price_range) {
            $priceRange = $request->price_range;
            if ($priceRange === '0-7500000') {
                $query->whereBetween('price', [0, 7500000]);
            } elseif ($priceRange === '7500000-22500000') {
                $query->whereBetween('price', [7500000, 22500000]);
            } elseif ($priceRange === '22500000-45000000') {
                $query->whereBetween('price', [22500000, 45000000]);
            } elseif ($priceRange === '45000000+') {
                $query->where('price', '>=', 45000000);
            }
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        if ($sort === 'price-low') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price-high') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'popular') {
            $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('collections.index', compact('category', 'products', 'categories'));
    }

    /**
     * Display all categories
     */
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->get();

        return view('collections.categories', compact('categories'));
    }
}
