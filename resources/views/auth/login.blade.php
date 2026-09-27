<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('ui.auth.login.sign_in_1989_studio') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-charcoal font-sans">
        @include('layouts.navigation')

        <div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-blush-50 to-white pt-20 pb-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md">
                <!-- Header -->
                <div class="text-center mb-10">
                    <a href="/" class="inline-block mb-6">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blush-400 to-rose-gold flex items-center justify-center text-white font-serif font-bold text-2xl shadow-soft">
                            L
                        </div>
                    </a>
                    <h1 class="text-4xl font-serif font-bold text-charcoal mb-2">{{ __('ui.auth.login.welcome_back') }}</h1>
                    <p class="text-gray-600">{{ __('ui.auth.login.sign_in_to_your_account_to_continue_shopping') }}</p>
                </div>

                <!-- Session Status -->
                @if ($errors->any)
                    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                        <p class="text-red-600 text-sm font-semibold">{{ __('ui.auth.login.login_failed') }}</p>
                        <p class="text-red-500 text-xs mt-1">{{ __('ui.auth.login.invalid_email_or_password_please_try_again') }}</p>
                    </div>
                @endif

                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-soft border border-blush-100 p-8">
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-charcoal mb-2">{{ __('ui.auth.login.email_address') }}</label>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                                class="w-full px-4 py-3 rounded-lg border border-blush-200 focus:border-blush-500 focus:ring-2 focus:ring-blush-500/20 outline-none transition-all bg-white text-charcoal placeholder-gray-400"
                                placeholder="{{ __('ui.auth.login.your_email_com') }}">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-charcoal mb-2">{{ __('ui.auth.login.password') }}</label>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="w-full px-4 py-3 rounded-lg border border-blush-200 focus:border-blush-500 focus:ring-2 focus:ring-blush-500/20 outline-none transition-all bg-white text-charcoal placeholder-gray-400"
                                placeholder="••••••••">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-blush-300 text-blush-500 focus:ring-blush-500 focus:ring-2" name="remember">
                                <span class="ms-2 text-sm text-gray-600">{{ __('ui.auth.login.remember_me') }}</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-blush-500 hover:text-blush-600 transition-colors">
                                    {{ __('ui.auth.login.forgot_password') }}
                                </a>
                            @endif
                        </div>

                        <!-- Sign In Button -->
                        <button type="submit" class="w-full bg-blush-500 hover:bg-blush-600 text-white font-semibold py-3 rounded-lg transition-colors duration-200 shadow-soft hover:shadow-md mt-8">
                            {{ __('ui.auth.login.sign_in_button') }}
                        </button>

                        <!-- Sign Up Link -->
                        <p class="text-center text-gray-600 text-sm">
                            {{ __('ui.auth.login.dont_have_account') }}
                            <a href="{{ route('register') }}" class="font-semibold text-blush-500 hover:text-blush-600 transition-colors">
                                {{ __('ui.auth.register.create_account') }}
                            </a>
                        </p>
                    </form>
                </div>

                <!-- Divider with OR -->
                <div class="flex items-center gap-4 my-8">
                    <div class="flex-1 h-px bg-blush-200"></div>
                    <span class="text-sm text-gray-400">{{ __('ui.auth.login.or') }}</span>
                    <div class="flex-1 h-px bg-blush-200"></div>
                </div>

                <!-- Google Login Button -->
                <a href="{{ route('auth.google') }}" class="flex items-center justify-center w-full bg-white border-2 border-blush-200 hover:border-blue-500 hover:bg-blue-50 text-gray-700 font-semibold py-3 rounded-lg transition-all duration-200 mb-4">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    {{ __('ui.auth.login.sign_in_with_google') }}
                </a>

                <!-- Continue as Guest -->
                <a href="/" class="block w-full text-center border-2 border-blush-200 hover:border-blush-500 text-blush-600 hover:text-blush-700 font-semibold py-3 rounded-lg transition-all duration-200">
                    {{ __('ui.auth.login.continue_as_guest') }}
                </a>
            </div>
        </div>
    </body>
</html>
