@props(['product'])

<div class="group relative">
    <div class="relative w-full aspect-[4/5] overflow-hidden rounded-2xl bg-gray-100 mb-4">
        
        @if(isset($product->is_new) && $product->is_new)
            <div class="absolute top-3 left-3 z-10">
                <span class="px-3 py-1 text-xs font-semibold tracking-wider text-white uppercase bg-gray-900 rounded-full">New</span>
            </div>
        @elseif(isset($product->discount_price))
             <div class="absolute top-3 left-3 z-10">
                <span class="px-3 py-1 text-xs font-semibold tracking-wider text-white uppercase bg-red-500 rounded-full">Sale</span>
            </div>
        @endif

        @php
            $imageUrl = $product->image ? \Illuminate\Support\Facades\Storage::url($product->image) : 'https://via.placeholder.com/400x500';
        @endphp
        <img src="{{ $imageUrl }}" 
             alt="{{ $product->name }}" 
             loading="lazy"
             class="h-full w-full object-cover object-center transition-transform duration-700 group-hover:scale-110">

        <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 ease-in-out z-20">
            @auth
                <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full bg-white/90 backdrop-blur-sm text-gray-900 font-medium py-3 rounded-xl shadow-lg hover:bg-blush-500 hover:text-white transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Add to Cart
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full bg-white/90 backdrop-blur-sm text-gray-900 font-medium py-3 rounded-xl shadow-lg hover:bg-blush-500 hover:text-white transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Login to Buy
                </a>
            @endauth
        </div>
        
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300 pointer-events-none"></div>
    </div>

    <div class="text-center space-y-1">
        <p class="text-xs text-gray-500 uppercase tracking-widest">{{ $product->category->name ?? 'Jewelry' }}</p>
        
        <h3 class="text-lg font-serif font-medium text-gray-900 group-hover:text-blush-500 transition-colors">
            @if($product->slug)
                <a href="{{ route('products.show', $product->slug) }}">
                    {{ $product->name ?? 'Product Name' }}
                </a>
            @else
                <span>{{ $product->name ?? 'Product Name' }}</span>
            @endif
        </h3>

        <div class="flex items-center justify-center gap-3 text-sm font-medium">
            @if(isset($product->discount_price) && $product->discount_price)
                <span class="text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                <span class="text-red-500">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
            @else
                <span class="text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            @endif
        </div>
    </div>
</div>