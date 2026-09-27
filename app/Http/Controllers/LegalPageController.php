<?php

namespace App\Http\Controllers;

use App\Models\LegalPage;
use Illuminate\Http\Request;

class LegalPageController extends Controller
{
    /**
     * Display a legal page
     */
    public function show(LegalPage $legalPage)
    {
        // Only show active pages
        if (!$legalPage->is_active) {
            abort(404);
        }

        return view('pages.legal', compact('legalPage'));
    }
}
