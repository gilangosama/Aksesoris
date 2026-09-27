<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect user to Google for authentication
     */
    public function redirect()
    {
        Log::info('Google auth redirect initiated');
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function callback()
    {
        try {
            Log::info('Google callback received', [
                'method' => request()->method(),
                'code' => request()->query('code') ? 'present' : 'missing',
                'state' => request()->query('state') ? 'present' : 'missing',
            ]);

            // Use stateless auth for OAuth callback
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            Log::info('Google user data obtained', [
                'email' => $googleUser->getEmail(),
                'id' => $googleUser->getId(),
                'name' => $googleUser->getName(),
            ]);

            // Find or create user
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(),
                    'password' => bcrypt(str()->random(32)),
                ]
            );

            // Update google_id if creating existing user
            if (!$user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
                Log::info('Updated google_id for existing user', ['user_id' => $user->id]);
            }

            Log::info('User authenticated via Google', ['user_id' => $user->id]);

            // Login user
            Auth::login($user, remember: true);

            return redirect()->intended(route('dashboard'));

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::warning('Google OAuth - Invalid state exception', [
                'message' => $e->getMessage(),
            ]);
            return redirect('/login')->with('error', 'Authentication failed. Please try again.');

        } catch (\Exception $e) {
            Log::error('Google OAuth callback error', [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            
            return redirect('/login')->with('error', 'Failed to authenticate. Please try again.');
        }
    }
}
