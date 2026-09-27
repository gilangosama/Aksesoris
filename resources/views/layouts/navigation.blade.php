<nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 bg-white/98 backdrop-blur-md z-50 border-b border-blush-100 shadow-softer">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo Section -->
            <div class="shrink-0 flex items-center">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blush-400 to-rose-gold flex items-center justify-center text-white font-serif font-bold text-lg shadow-soft group-hover:shadow-lg transition-shadow">
                        L
                    </div>
                    <span class="font-serif font-bold text-xl text-charcoal hidden sm:inline">1989 Studio</span>
                </a>
            </div>

            <!-- Center Navigation Links -->
            <div class="hidden lg:flex items-center gap-12">
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-charcoal hover:text-blush-500 transition-colors duration-300 relative group">
                    {{ __('navigation.products') }}
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blush-500 to-rose-gold group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('collections.index') }}" class="text-sm font-semibold text-charcoal hover:text-blush-500 transition-colors duration-300 relative group">
                    {{ __('navigation.collections') }}
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blush-500 to-rose-gold group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <!-- Right Section: Language, Cart, {{ __('ui.layouts.navigation.whatsapp') }}, {{ __('ui.layouts.navigation.profile') }}, Create Custom -->
            <div class="flex items-center gap-4 sm:gap-6">
                <!-- Language Switcher -->
                <div class="hidden sm:flex items-center gap-2 bg-blush-50 rounded-full p-1">
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'id']) }}" 
                       class="px-3 py-1.5 text-xs font-semibold rounded-full transition-all {{ app()->getLocale() === 'id' ? 'bg-white text-blush-600 shadow-sm' : 'text-gray-600 hover:text-blush-500' }}">
                        🇮🇩 ID
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" 
                       class="px-3 py-1.5 text-xs font-semibold rounded-full transition-all {{ app()->getLocale() === 'en' ? 'bg-white text-blush-600 shadow-sm' : 'text-gray-600 hover:text-blush-500' }}">
                        🇬🇧 EN
                    </a>
                </div>

                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}" class="relative group p-2.5 hover:bg-blush-50 rounded-full transition-colors duration-200">
                    <svg class="w-6 h-6 text-blush-600 group-hover:text-rose-gold transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span id="cart-badge" class="absolute -top-1 -right-1 w-5 h-5 bg-rose-gold text-white text-xs font-bold rounded-full flex items-center justify-center shadow-md">0</span>
                </a>

                <!-- {{ __('ui.layouts.navigation.whatsapp') }} Icon -->
                <a href="https://wa.me/1234567890" target="_blank" rel="noopener noreferrer" aria-label="{{ __('navigation.whatsapp') }}" class="hidden sm:flex items-center justify-center p-2.5 hover:bg-blush-50 rounded-full transition-colors duration-200 group">
                <svg class="w-6 h-6 text-charcoal group-hover:text-blush-500 transition-colors" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.008-.57-.008-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.374-5.03c0-5.445 4.429-9.876 9.88-9.876 2.64 0 5.122 1.03 6.988 2.894a9.825 9.825 0 012.893 6.991c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
</a>

                <!-- {{ __('ui.layouts.navigation.profile') }} Dropdown -->
                <div x-data="{ profileOpen: false }" class="relative hidden sm:block">
                    @auth
                        <button @click="profileOpen = !profileOpen" class="flex items-center gap-2 px-4 py-2.5 hover:bg-blush-50 rounded-full transition-colors duration-200 border border-blush-100 hover:border-blush-300">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blush-400 to-rose-gold flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-charcoal">{{ Auth::user()->name }}</span>
                            <svg x-show="!profileOpen" class="w-4 h-4 text-gray-500 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                            <svg x-show="profileOpen" class="w-4 h-4 text-gray-500 transition-transform rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </button>
                        <div @click.away="profileOpen = false" x-show="profileOpen" class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-blush-100 overflow-hidden z-50" style="display: none;">
                            <!-- {{ __('ui.layouts.navigation.profile') }} Links -->
                            <div class="py-2 space-y-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-charcoal hover:bg-blush-50 transition-colors duration-200 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blush-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    {{ __('navigation.profile') }}
                                </a>
                            </div>
                            <!-- {{ __('ui.layouts.navigation.logout') }} -->
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-blush-100">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('ui.layouts.navigation.logout') }}
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-semibold text-blush-500 border-2 border-blush-500 rounded-full hover:bg-blush-50 transition-colors">
                            {{ __('navigation.sign_in') }}
                        </a>
                    @endauth
                </div>

                <!-- Create Custom Button -->
                <a href="{{ route('create-custom.type') }}" class="hidden sm:block btn-primary text-sm px-6 py-2.5 font-semibold">
                    {{ __('navigation.create_custom') }}
                </a>


                <!-- Hamburger Menu -->
                <div class="lg:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2.5 rounded-full text-charcoal hover:text-blush-500 hover:bg-blush-50 focus:outline-none transition duration-200 focus:ring-2 focus:ring-blush-200">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden bg-gradient-to-b from-blush-50 to-white border-t border-blush-100">
        <div class="px-4 pt-4 pb-3 space-y-2">
            <a href="{{ route('products.index') }}" class="block px-4 py-3 rounded-full text-base font-semibold text-charcoal hover:text-blush-500 hover:bg-white transition-colors">
                {{ __('navigation.products') }}
            </a>
            <a href="{{ route('collections.index') }}" class="block px-4 py-3 rounded-full text-base font-semibold text-charcoal hover:text-blush-500 hover:bg-white transition-colors">
                {{ __('navigation.collections') }}
            </a>
            <a href="{{ route('cart.index') }}" class="block px-4 py-3 rounded-full text-base font-semibold text-blush-600 hover:text-rose-gold hover:bg-white transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                {{ __('navigation.cart') }}
            </a>

            <!-- Mobile Language Switcher -->
            <div class="px-4 py-3 flex gap-2">
                <a href="{{ request()->fullUrlWithQuery(['lang' => 'id']) }}" 
                   class="flex-1 px-3 py-2 text-sm font-semibold rounded-full text-center transition-all {{ app()->getLocale() === 'id' ? 'bg-blush-500 text-white shadow-sm' : 'bg-blush-100 text-charcoal hover:bg-blush-200' }}">
                    🇮🇩 ID
                </a>
                <a href="{{ request()->fullUrlWithQuery(['lang' => 'en']) }}" 
                   class="flex-1 px-3 py-2 text-sm font-semibold rounded-full text-center transition-all {{ app()->getLocale() === 'en' ? 'bg-blush-500 text-white shadow-sm' : 'bg-blush-100 text-charcoal hover:bg-blush-200' }}">
                    🇬🇧 EN
                </a>
            </div>

            <a href="https://wa.me/1234567890" target="_blank" rel="noopener noreferrer" aria-label="{{ __('navigation.whatsapp') }}" class="block px-4 py-3 rounded-full text-base font-semibold text-charcoal hover:text-blush-500 hover:bg-white transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M16.75 3.25C13.1 3.25 10.05 4.86 8.07 7.52L6.5 9.5l-1.5.5L5.5 11.5c1.4 2.5 3.9 4.9 7.9 6.15 3.94 1.23 6.85.9 8.5-1.4 1.64-2.3 1.62-5.98-1.6-9.5-1.66-1.92-4-2.92-6.55-2.92z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M15.2 13.1c-.25.7-1.4 1.5-2.1 1.6-.6.08-1 .12-1.9-.1-1-.23-2.1-.75-3.5-2.35-.9-1-1.1-1.6-1.2-1.85-.1-.25.02-.45.17-.6.15-.14.34-.35.5-.55.15-.2.2-.36.3-.55.1-.2.03-.4-.06-.6-.1-.2-.72-1.9-.94-2.6-.2-.7-.47-.6-.7-.6-.25 0-.55 0-.85 0-.3 0-.8.08-1.2.35-.4.27-1.2 1.1-1.2 2.6 0 1.5.95 3 1.08 3.22.12.22 1.6 2.8 4.2 4.16 2.6 1.36 3 .92 3.6 0 .56-.9 1.2-2.45 1.2-3.7 0-1.2-.16-1.72-.34-1.9z" fill="currentColor" />
                </svg>
                {{ __('ui.layouts.navigation.whatsapp') }}
            </a>
        </div>

        <!-- Mobile Auth Section -->
        <div class="pt-4 pb-3 border-t border-blush-100 bg-white">
            @auth
                <div class="px-4 mb-3 pb-3 border-b border-blush-100">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blush-400 to-rose-gold flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-base text-charcoal">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>
                <div class="space-y-1 px-2">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 rounded-full text-base font-medium text-charcoal hover:text-blush-500 hover:bg-blush-50 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        {{ __('ui.layouts.navigation.profile') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 rounded-full text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            {{ __('ui.layouts.navigation.logout') }}
                        </button>
                    </form>
                </div>
            @else
                <div class="space-y-2 px-2 mb-3">
                    <a href="{{ route('login') }}" class="block px-4 py-2 rounded-full text-base font-semibold text-blush-500 border-2 border-blush-500 hover:bg-blush-50 transition-colors text-center">
                        {{ __('navigation.sign_in') }}
                    </a>
                    <a href="{{ route('create-custom.type') }}" class="btn-primary w-full text-sm font-semibold rounded-full py-2.5 block text-center">{{ __('navigation.create_custom') }}</a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<script>
// Initialize cart badge on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartBadge();
});

// Function to update cart badge from server
function updateCartBadge() {
    fetch('{{ route("cart.count") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        const badge = document.getElementById('cart-badge');
        if (badge) {
            badge.textContent = data.total_items || 0;
        }
    })
    .catch(error => console.error('Error fetching cart count:', error));
}

// Update cart badge when adding to cart
function addToCartAndUpdate(productId, quantity = 1) {
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update badge immediately with response data
            const badge = document.getElementById('cart-badge');
            if (badge) {
                badge.textContent = data.total_items || 0;
            }
            // Show success message
            if (data.message) {
                showNotification(data.message, 'success');
            }
        } else {
            showNotification(data.message || 'Failed to add to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to add to cart', 'error');
    });
}

// Simple notification function
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
