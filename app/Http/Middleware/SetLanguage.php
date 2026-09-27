<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if language is provided in query string
        $lang = $request->query('lang');

        // Validate language is one of supported locales
        $supportedLocales = ['en', 'id'];
        
        if ($lang && in_array($lang, $supportedLocales)) {
            // Store in session for persistence
            session(['locale' => $lang]);
            app()->setLocale($lang);
        } else {
            // Try to get from session
            $sessionLocale = session('locale');
            
            if ($sessionLocale && in_array($sessionLocale, $supportedLocales)) {
                app()->setLocale($sessionLocale);
            } else {
                // Default to config locale
                app()->setLocale(config('app.locale'));
            }
        }

        return $next($request);
    }
}
