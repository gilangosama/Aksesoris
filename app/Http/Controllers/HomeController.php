<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Product;
use App\Models\OrderRating;

class HomeController extends Controller
{
    public function index()
    {
        // Eager load category to avoid N+1 query
        $featuredProducts = Product::with('category')
            ->where('is_featured', true)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        // Get active galleries
        $galleries = Gallery::where('is_active', true)->get();

        $testimonials = OrderRating::with(['user', 'order'])
            ->whereHas('order', fn ($query) => $query->where('status', 'success'))
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('welcome', compact('featuredProducts', 'galleries', 'testimonials'));
    }
}
