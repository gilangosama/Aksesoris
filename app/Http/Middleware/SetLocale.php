<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = config('app.locale');

        // Priority 1: Check cookie (always safe to access)
        if ($request->cookie('locale')) {
            $locale = $request->cookie('locale');
        }
        // Priority 2: Check session (only if available)
        elseif ($request->hasSession()) {
            try {
                $sessionLocale = $request->session()->get('locale');
                if ($sessionLocale) {
                    $locale = $sessionLocale;
                }
            } catch (\Exception $e) {
                // Ignore any session errors, use default
            }
        }

        // Validate locale is in allowed list
        if (!in_array($locale, ['en', 'id'])) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
