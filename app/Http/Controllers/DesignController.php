<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\DesignInquiry;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    /**
     * Display all design portfolios with filtering and sorting
     */
    public function index(Request $request)
    {
        $query = Design::where('is_active', true);

        // Filter by type (radio)
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Filter by style (checkbox array) - supports array or single value
        if ($request->has('style') && is_array($request->style)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->style as $style) {
                    $q->orWhere('style', 'like', "%{$style}%");
                }
            });
        } elseif ($request->has('style') && $request->style) {
            $query->where('style', 'like', "%{$request->style}%");
        }

        // Filter by material (if provided as array)
        if ($request->has('material') && is_array($request->material)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->material as $material) {
                    $q->orWhere('material', 'like', "%{$material}%");
                }
            });
        } elseif ($request->has('material') && $request->material) {
            $query->where('material', 'like', "%{$request->material}%");
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        if ($sort === 'popular') {
            $query->orderBy('client_pick', 'desc')->orderBy('created_at', 'desc');
        } elseif ($sort === 'trending') {
            $query->where('trending', true)->orderBy('created_at', 'desc');
        } elseif ($sort === 'favorites') {
            $query->orderBy('client_pick', 'desc')->orderBy('featured', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $designs = $query->paginate(12)->withQueryString();

        return view('designs.index', compact('designs'));
    }

    /**
     * Display single design detail
     */
    public function show($slug)
    {
        $design = Design::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get similar designs (same type)
        $relatedDesigns = Design::where('type', $design->type)
            ->where('id', '!=', $design->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('designs.show', compact('design', 'relatedDesigns'));
    }

    /**
     * Handle inquiry submission from the designs modal.
     */
    public function storeInquiry(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'budget' => 'required|string',
            'description' => 'required|string|min:10',
            'reference_design' => 'nullable|string',
            'material' => 'nullable|string',
        ]);

        $inquiry = DesignInquiry::create([
            'user_id' => auth()->id(),
            'reference_design' => $request->input('reference_design'),
            'type' => $request->input('type'),
            'budget' => $request->input('budget'),
            'material' => $request->input('material'),
            'description' => $request->input('description'),
        ]);

        return back()->with('success', 'Your custom design request has been sent! We will contact you shortly.');
    }
}
