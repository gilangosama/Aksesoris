<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('ui.auth.register.create_account_1989_studio') }}</title>
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
                    <h1 class="text-4xl font-serif font-bold text-charcoal mb-2">{{ __('ui.auth.register.create_account') }}</h1>
                    <p class="text-gray-600">{{ __('ui.auth.register.join_us_and_start_exploring_beautiful_jewelry') }}</p>
                </div>

                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-soft border border-blush-100 p-8">
                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-charcoal mb-2">{{ __('ui.auth.register.full_name') }}</label>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                class="w-full px-4 py-3 rounded-lg border border-blush-200 focus:border-blush-500 focus:ring-2 focus:ring-blush-500/20 outline-none transition-all bg-white text-charcoal placeholder-gray-400"
                                placeholder="{{ __('ui.auth.register.john_doe') }}">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-charcoal mb-2">{{ __('ui.auth.register.email_address') }}</label>
                            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                                class="w-full px-4 py-3 rounded-lg border border-blush-200 focus:border-blush-500 focus:ring-2 focus:ring-blush-500/20 outline-none transition-all bg-white text-charcoal placeholder-gray-400"
                                placeholder="{{ __('ui.auth.register.your_email_com') }}">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-charcoal mb-2">{{ __('ui.auth.register.password') }}</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                class="w-full px-4 py-3 rounded-lg border border-blush-200 focus:border-blush-500 focus:ring-2 focus:ring-blush-500/20 outline-none transition-all bg-white text-charcoal placeholder-gray-400"
                                placeholder="••••••••">
                            <p class="mt-2 text-xs text-gray-500">{{ __('ui.auth.register.at_least_8_characters_with_uppercase_lowercase_and_numbers') }}</p>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-charcoal mb-2">{{ __('ui.auth.register.confirm_password') }}</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                class="w-full px-4 py-3 rounded-lg border border-blush-200 focus:border-blush-500 focus:ring-2 focus:ring-blush-500/20 outline-none transition-all bg-white text-charcoal placeholder-gray-400"
                                placeholder="••••••••">
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Agreement Checkbox -->
                        <div class="flex items-start">
                            <input id="agree" type="checkbox" class="w-4 h-4 rounded border-blush-300 text-blush-500 focus:ring-blush-500 focus:ring-2 mt-0.5" name="agree" required>
                            <label for="agree" class="ms-2 text-sm text-gray-600">
                                {{ __('ui.auth.register.i_agree_to_the') }} <a href="#" class="text-blush-500 font-semibold hover:text-blush-600">{{ __('ui.auth.register.terms_of_service') }}</a> {{ __('ui.auth.register.and') }} <a href="#" class="text-blush-500 font-semibold hover:text-blush-600">{{ __('ui.auth.register.privacy_policy') }}</a>
                            </label>
                        </div>

                        <!-- Sign Up Button -->
                        <button type="submit" class="w-full bg-blush-500 hover:bg-blush-600 text-white font-semibold py-3 rounded-lg transition-colors duration-200 shadow-soft hover:shadow-md mt-8">
                            {{ __('ui.auth.register.create_account_button') }}
                        </button>

                        <!-- Sign In Link -->
                        <p class="text-center text-gray-600 text-sm">
                            {{ __('ui.auth.register.already_have_an_account') }}
                            <a href="{{ route('login') }}" class="font-semibold text-blush-500 hover:text-blush-600 transition-colors">
                                {{ __('ui.auth.register.sign_in') }}
                            </a>
                        </p>
                    </form>
                </div>

                <!-- Benefits Section -->
                <div class="mt-10 pt-8 border-t border-blush-100">
                    <p class="text-center text-sm text-gray-600 mb-4 font-semibold">{{ __('ui.auth.register.why_create_an_account') }}</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-2xl mb-2">✓</div>
                            <p class="text-xs text-gray-600">{{ __('ui.auth.register.fast_checkout') }}</p>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl mb-2">❤</div>
                            <p class="text-xs text-gray-600">{{ __('ui.auth.register.save_favorites') }}</p>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl mb-2">🎁</div>
                            <p class="text-xs text-gray-600">{{ __('ui.auth.register.exclusive_deals') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
