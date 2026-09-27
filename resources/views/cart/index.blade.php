<x-app-layout>
<div class="min-h-screen bg-white pt-24 pb-16">
    <div class="container-centered px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-8 text-sm text-gray-500">
            <a href="{{ route('products.index') }}" class="hover:text-blush-500 transition-colors">{{ __('ui.cart.index.products') }}</a>
            <span class="mx-2">/</span>
            <span class="text-charcoal font-medium">{{ __('ui.cart.index.shopping_cart') }}</span>
        </nav>

        <h1 class="text-3xl md:text-4xl font-serif font-bold text-charcoal mb-8 md:mb-12">{{ __('ui.cart.index.your_shopping_bag') }}</h1>

        @if(count($cart) === 0)
            <div class="flex flex-col items-center justify-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-soft mb-6">
                    <svg class="w-10 h-10 text-blush-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h2 class="text-xl font-serif font-bold text-gray-900 mb-2">{{ __('ui.cart.index.your_cart_is_currently_empty') }}</h2>
                <p class="text-gray-500 mb-8 text-center max-w-md">{{ __('ui.cart.index.looks_like_you_haven_t_discovered_our_latest_treasures_yet') }}</p>
                <a href="{{ route('products.index') }}" class="btn-primary px-8 py-3 rounded-full font-semibold shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                    {{ __('ui.cart.index.start_shopping') }}
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                <div class="lg:col-span-2 space-y-6">
                    @foreach($cart as $id => $item)
                        <div class="group flex flex-col sm:flex-row items-start sm:items-center gap-6 p-6 bg-white rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                            
                            <div class="relative w-full sm:w-28 aspect-square flex-shrink-0 overflow-hidden rounded-2xl bg-gray-100">
                                @if(isset($item['image']))
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover object-center" alt="{{ $item['name'] }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">{{ __('ui.cart.index.no_image') }}</div>
                                @endif
                            </div>
                            
                            <div class="flex-1 w-full">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-xs text-blush-500 font-bold uppercase tracking-wider mb-1">{{ $item['category'] ?? 'Jewelry' }}</p>
                                        <h3 class="font-serif font-bold text-charcoal text-lg hover:text-blush-500 transition-colors">
                                            <a href="{{ route('products.show', $item['slug']) }}">{{ $item['name'] }}</a>
                                        </h3>
                                        @if(isset($item['attributes'])) 
                                            <p class="text-sm text-gray-500 mt-1">{{ $item['attributes'] }}</p>
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('cart.remove') }}" class="sm:hidden">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>

                                <div class="flex items-center justify-between mt-6">
                                    <div class="flex items-center border border-gray-200 rounded-full bg-gray-50/50">
                                        <button onclick="updateQuantity('{{ $item['id'] }}', -1)" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-charcoal transition-colors focus:outline-none">-</button>
                                        <input type="text" id="qty-{{ $item['id'] }}" value="{{ $item['quantity'] }}" readonly class="w-8 text-center bg-transparent border-none p-0 text-sm font-semibold text-charcoal focus:ring-0">
                                        <button onclick="updateQuantity('{{ $item['id'] }}', 1)" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-charcoal transition-colors focus:outline-none">+</button>
                                    </div>

                                    <div class="text-right">
                                        <p class="font-bold text-lg text-charcoal">{{ __('ui.cart.index.rp') }} {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                        @if($item['quantity'] > 1)
                                            <p class="text-xs text-gray-500">{{ __('ui.cart.index.rp') }} {{ number_format($item['price'], 0, ',', '.') }} / item</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="hidden sm:block ml-4">
                                <form method="POST" action="{{ route('cart.remove') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                    <button type="submit" class="group/trash p-2 rounded-full hover:bg-red-50 transition-colors" title="{{ __('ui.cart.index.remove_item') }}">
                                        <svg class="w-5 h-5 text-gray-400 group-hover/trash:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-28 bg-white rounded-3xl shadow-soft border border-blush-50 p-6 lg:p-8">
                        <h2 class="font-serif font-bold text-xl text-charcoal mb-6">{{ __('ui.cart.index.order_summary') }}</h2>
                        
                        <div class="space-y-3 mb-6 pb-6 border-b border-gray-100 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>{{ __('ui.cart.index.subtotal') }}</span>
                                <span class="font-medium text-charcoal">{{ __('ui.cart.index.rp') }} {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>{{ __('ui.cart.index.shipping_estimate') }}</span>
                                <span class="text-green-600 font-medium">{{ __('ui.cart.index.calculated_at_checkout') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>{{ __('ui.cart.index.tax') }}</span>
                                <span class="text-gray-400">–</span>
                            </div>
                        </div>

                        <div x-data="{ open: false }" class="mb-6 pb-6 border-b border-gray-100">
                            <button @click="open = !open" class="flex items-center justify-between w-full text-sm font-medium text-charcoal hover:text-blush-500 transition-colors">
                                <span>{{ __('ui.cart.index.have_a_promo_code') }}</span>
                                <span x-text="open ? '-' : '+'"></span>
                            </button>
                            <div x-show="open" class="mt-3 flex gap-2" style="display: none;">
                                <input type="text" placeholder="{{ __('ui.cart.index.enter_code') }}" class="w-full text-sm border-gray-300 rounded-lg focus:ring-blush-500 focus:border-blush-500">
                                <button class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800">{{ __('ui.cart.index.apply') }}</button>
                            </div>
                        </div>

                        <div class="flex justify-between items-end mb-8">
                            <span class="text-base font-medium text-charcoal">{{ __('ui.cart.index.total') }}</span>
                            <span class="text-2xl font-serif font-bold text-charcoal">{{ __('ui.cart.index.rp') }} {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('cart.checkout') }}" class="block w-full text-center btn-primary py-4 rounded-xl font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all mb-4">
                            {{ __('ui.cart.index.proceed_to_checkout') }}
                        </a>

                        <div class="flex flex-col items-center gap-3">
                            <div class="flex items-center justify-center gap-2 opacity-60 grayscale hover:grayscale-0 transition-all">
                            <span class="text-xs text-gray-400">{{ __('ui.cart.index.secure_payment_via') }}</span>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" class="h-4 object-contain">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" class="h-4 object-contain">
                            </div>
                            <p class="text-xs text-gray-400 text-center flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                {{ __('ui.cart.index.ssl_secure_transaction') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<form id="update-cart-form" action="{{ route('cart.update') }}" method="POST" class="hidden">
    @csrf
    @method('PATCH')
    <input type="hidden" name="id" id="update-id">
    <input type="hidden" name="quantity" id="update-qty">
</form>

</x-app-layout>

<script>
    function updateQuantity(itemId, change) {
        const input = document.getElementById('qty-' + itemId);
        let newQty = parseInt(input.value) + change;
        
        if (newQty < 1) return; // Minimum 1 item

        // Update UI immediately for responsiveness
        input.value = newQty;

        // Submit to server
        // Cara 1: Submit Form (Reload Page) - Paling Aman & Mudah
        /*
        document.getElementById('update-id').value = itemId;
        document.getElementById('update-qty').value = newQty;
        document.getElementById('update-cart-form').submit();
        */

        // Cara 2: Fetch API (Tanpa Reload) - Lebih Modern
        fetch('{{ route("cart.update") }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: itemId,
                quantity: newQty
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Reload page to calculate totals correctly (simplest way)
                // Atau update DOM element total price secara manual
                window.location.reload(); 
            } else {
                alert('Failed to update cart');
                input.value = newQty - change; // Revert
            }
        })
        .catch(error => {
            console.error('Error:', error);
            input.value = newQty - change; // Revert
        });
    }
</script>