<x-app-layout>
    <x-toast /> 

    <div class="min-h-screen bg-white pt-24 pb-16">
        <div class="container-centered px-4 sm:px-6 lg:px-8">
            
            <nav class="flex mb-8 text-sm text-gray-500" aria-label="{{ __('ui.product.show.breadcrumb') }}">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="{{ route('products.index') }}" class="hover:text-blush-500 transition-colors">{{ __('ui.product.show.products') }}</a></li>
                    <li><span class="text-gray-300">/</span></li>
                    <li><a href="{{ route('collections.show', $product->category->slug) }}" class="hover:text-blush-500 transition-colors">{{ $product->category->name }}</a></li>
                    <li><span class="text-gray-300">/</span></li>
                    <li class="text-charcoal font-medium truncate max-w-[150px] sm:max-w-none">{{ $product->name }}</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">
                
                <div class="relative" x-data="productGallery()" x-init="init()">
                    <div class="lg:sticky lg:top-28 space-y-4">
                        <div class="group relative w-full aspect-[4/5] bg-gray-50 rounded-3xl overflow-hidden shadow-sm">
                            @if($product->image)
                                    @php
                                        $mainImageUrl = \Illuminate\Support\Facades\Storage::url($product->image);
                                    @endphp
                                    <img x-bind:src="mainImage" alt="{{ $product->name }}" class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105 cursor-zoom-in">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-blush-50 text-blush-300">
                                    <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif

                            @if($product->original_price && $product->original_price > $product->price)
                                <div class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">
                                    {{ __('ui.product.show.sale') }}
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-4 gap-4">
                            <!-- Main image thumbnail -->
                            <button class="aspect-square rounded-xl border-2 border-blush-500 overflow-hidden p-0.5 transition-all hover:shadow-md" @click="selectImage('{{ \Illuminate\Support\Facades\Storage::url($product->image) }}')">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}" class="w-full h-full object-cover rounded-lg cursor-pointer" alt="{{ __('ui.product.show.main_image') }}">
                            </button>
                            
                            <!-- Gallery images -->
                            @if($product->images && is_array($product->images))
                                @foreach($product->images as $index => $galleryImage)
                                    @if($index < 3)
                                        <button class="aspect-square rounded-xl border border-transparent hover:border-blush-300 overflow-hidden bg-gray-50 transition-all hover:shadow-md" @click="selectImage('{{ \Illuminate\Support\Facades\Storage::url($galleryImage) }}')">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($galleryImage) }}" class="w-full h-full object-cover rounded-lg cursor-pointer" alt="Product image {{ $index + 1 }}">
                                        </button>
                                    @endif
                                @endforeach
                                
                                <!-- Empty slots if less than 3 gallery images -->
                                @for($i = count($product->images); $i < 3; $i++)
                                    <button class="aspect-square rounded-xl border border-transparent hover:border-blush-300 overflow-hidden bg-gray-50" disabled></button>
                                @endfor
                            @else
                                <!-- Empty slots if no gallery images -->
                                <button class="aspect-square rounded-xl border border-transparent hover:border-blush-300 overflow-hidden bg-gray-50" disabled></button>
                                <button class="aspect-square rounded-xl border border-transparent hover:border-blush-300 overflow-hidden bg-gray-50" disabled></button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-col">
                    <div class="border-b border-gray-100 pb-8 mb-8">
                        <p class="text-sm font-semibold text-blush-500 uppercase tracking-widest mb-2">{{ $product->category->name }}</p>
                        <h1 class="text-4xl lg:text-5xl font-serif font-bold text-gray-900 mb-4 leading-tight">{{ $product->name }}</h1>
                        
                        <div class="flex items-center gap-6 mt-6">
                            <div class="flex items-baseline gap-3">
                                <span class="text-3xl font-medium text-gray-900">{{ __('ui.product.show.rp') }} {{ number_format($product->price, 0, ',', '.') }}</span>
                                @if($product->original_price && $product->original_price > $product->price)
                                    <span class="text-lg text-gray-400 line-through">{{ __('ui.product.show.rp') }} {{ number_format($product->original_price, 0, ',', '.') }}</span>
                                @endif
                            </div>

                            <div class="flex items-center gap-2 text-sm font-medium {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                <span class="w-2 h-2 rounded-full {{ $product->stock > 0 ? 'bg-green-600' : 'bg-red-600' }}"></span>
                                {{ $product->stock > 0 ? __('ui.product.show.in_stock') : __('ui.product.show.sold_out') }}
                            </div>
                        </div>
                    </div>

                    <div class="prose prose-sm text-gray-600 mb-8 leading-relaxed">
                        <p>{{ $product->description }}</p>
                    </div>

                    <div class="mt-auto">
                        @auth
                            <form id="add-to-cart-form" class="space-y-6">
                                <div class="flex items-center gap-4">
                                    <span class="text-sm font-medium text-gray-700">{{ __('ui.product.show.quantity') }}</span>
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button" onclick="decrementQty()" class="px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-l-lg">-</button>
                                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center border-none focus:ring-0 p-0 text-gray-900 text-sm" readonly>
                                        <button type="button" onclick="incrementQty()" class="px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-r-lg">+</button>
                                    </div>
                                </div>

                                <div class="flex gap-4">
                                    <button 
                                        type="submit" 
                                        id="add-to-cart-btn"
                                        {{ $product->stock <= 0 ? 'disabled' : '' }}
                                        class="flex-1 btn-primary py-4 text-center font-bold tracking-wide shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                    >
                                        <span id="btn-text" class="flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                            {{ $product->stock > 0 ? __('ui.product.show.add_to_cart') : __('ui.product.show.out_of_stock') }}
                                        </span>
                                    </button>
                                    
                                    <button type="button" class="w-14 flex items-center justify-center border border-gray-300 rounded-full text-gray-400 hover:text-red-500 hover:border-red-500 hover:bg-red-50 transition-all">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    </button>
                                </div>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block w-full btn-primary py-4 text-center font-bold shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                                {{ __('ui.product.show.sign_in_to_shop') }}
                            </a>
                        @endauth

                        <div class="mt-8 space-y-4 border-t border-gray-100 pt-8">
                            <div class="flex items-center gap-3 text-sm text-gray-500">
                                <svg class="w-5 h-5 text-blush-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>{{ __('ui.product.show.free_shipping_on_orders_over_rp_1_000_000') }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-500">
                                <svg class="w-5 h-5 text-blush-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ __('ui.product.show.authenticity_guaranteed') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                <div class="mt-24 lg:mt-32">
                    <div class="text-center mb-12">
                        <span class="text-xs font-bold text-blush-500 uppercase tracking-widest">{{ __('ui.product.show.you_may_also_like') }}</span>
                        <h2 class="text-3xl md:text-4xl font-serif font-bold mt-2">{{ __('ui.product.show.complete_the_look') }}</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                        @foreach($relatedProducts as $related)
                            <x-product-card :product="$related" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
    // --- Quantity Logic ---
    function incrementQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.getAttribute('max'));
        if (parseInt(input.value) < max) input.value = parseInt(input.value) + 1;
    }

    function decrementQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
    }

    // --- Product Gallery with Alpine.js ---
    function productGallery() {
        return {
            mainImage: '{{ \Illuminate\Support\Facades\Storage::url($product->image) }}',
            init() {
                // Set initial main image
                this.mainImage = '{{ \Illuminate\Support\Facades\Storage::url($product->image) }}';
            },
            selectImage(imageUrl) {
                this.mainImage = imageUrl;
                
                // Update button borders
                const buttons = document.querySelectorAll('[x-data="productGallery()"] .grid button');
                buttons.forEach((btn, index) => {
                    const imgInButton = btn.querySelector('img');
                    if (imgInButton && imgInButton.src === imageUrl) {
                        btn.classList.remove('border', 'border-transparent', 'hover:border-blush-300');
                        btn.classList.add('border-2', 'border-blush-500', 'p-0.5');
                    } else {
                        btn.classList.remove('border-2', 'border-blush-500', 'p-0.5');
                        btn.classList.add('border', 'border-transparent', 'hover:border-blush-300');
                    }
                });
            }
        }
    }

    // --- Add to Cart Logic ---
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('add-to-cart-form');
        
        if (!form) return; // Exit if user is not logged in (form doesn't exist)

        const btn = document.getElementById('add-to-cart-btn');
        const btnText = document.getElementById('btn-text');
        
        // Ambil badge dari Navbar (pastikan ID-nya sesuai dengan yang ada di Navbar)
        const cartBadge = document.getElementById('cart-badge');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Loading State
            const originalText = btnText.innerHTML;
            btn.disabled = true;
            btnText.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> {{ __('ui.product.show.adding') }}</span>';

            const quantity = document.getElementById('quantity').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (!csrfToken) {
                alert('CSRF token mismatch. Please refresh.');
                resetButton(btn, btnText, originalText);
                return;
            }

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: {{ $product->id }},
                    quantity: quantity
                })
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) throw new Error(data.message || 'Server Error');
                return data;
            })
            .then(data => {
                // 1. Show Success Toast
                // Jika kamu punya fungsi global window.showToast, pakai itu. 
                // Jika tidak, pakai alert biasa atau buat fungsi toast sederhana di bawah.
                if (typeof window.showToast === 'function') {
                    window.showToast(data.message, 'success');
                } else {
                    alert(data.message); // Fallback
                }

                // 2. Update Navbar Badge (Check if exists first)
                if (cartBadge) {
                    cartBadge.textContent = data.total_items;
                    // Animasi Pop
                    cartBadge.classList.add('scale-125');
                    setTimeout(() => cartBadge.classList.remove('scale-125'), 200);
                }

                // 3. Reset Button State
                btnText.innerHTML = '<span class="flex items-center gap-2">{{ __('ui.product.show.added') }}</span>';
                setTimeout(() => {
                    resetButton(btn, btnText, originalText);
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                if (typeof window.showToast === 'function') {
                    window.showToast(error.message, 'error');
                } else {
                    alert('Error: ' + error.message);
                }
                resetButton(btn, btnText, originalText);
            });
        });

        function resetButton(btn, btnTextElement, originalHtml) {
            btn.disabled = false;
            btnTextElement.innerHTML = originalHtml;
        }
    });
</script>