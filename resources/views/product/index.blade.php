<x-app-layout>
<div class="pt-24 pb-12 lg:pb-20 bg-white">
    <!-- Page Header -->
    <div class="container-centered mb-12">
        <div class="max-w-4xl">
            <h1 class="text-4xl lg:text-5xl font-serif font-bold text-charcoal mb-4">{{ __('site.our_finest_pieces') }}</h1>
            <p class="text-lg text-gray-600">{{ __('site.hero_subheading') }}</p>
        </div>
    </div>

    <div class="container-centered">
        <div class="grid lg:grid-cols-4 gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:col-span-1">
                <div class="bg-blush-50 rounded-3xl p-6 sticky top-24">
                    <h2 class="text-xl font-serif font-bold text-charcoal mb-6">{{ __('site.filters') }}</h2>

                    <form action="{{ route('products.index') }}" method="GET" class="space-y-6">
                        <!-- Category Filter -->
                        <div>
                            <h3 class="font-semibold text-charcoal mb-3">{{ __('site.category') }}</h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" name="category" value="" onchange="this.form.submit()" {{ !request('category') ? 'checked' : '' }} class="w-4 h-4 text-blush-500 accent-blush-500">
                                    <span class="text-sm text-gray-600 group-hover:text-blush-500 transition-colors">{{ __('site.all_categories') }}</span>
                                </label>
                                @foreach($categories as $cat)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="radio" name="category" value="{{ $cat->id }}" onchange="this.form.submit()" {{ request('category') == $cat->id ? 'checked' : '' }} class="w-4 h-4 text-blush-500 accent-blush-500">
                                        <span class="text-sm text-gray-600 group-hover:text-blush-500 transition-colors">{{ $cat->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="border-t border-blush-200"></div>

                        <!-- Sort -->
                        <div>
                            <h3 class="font-semibold text-charcoal mb-3">{{ __('site.sort_by') }}</h3>
                            <select name="sort" onchange="this.form.submit()" class="w-full px-3 py-2 bg-white border border-blush-200 rounded-lg text-sm font-medium text-charcoal">
                                <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>{{ __('site.latest') }}</option>
                                <option value="price-low" {{ request('sort') === 'price-low' ? 'selected' : '' }}>{{ __('site.price_low_high') }}</option>
                                <option value="price-high" {{ request('sort') === 'price-high' ? 'selected' : '' }}>{{ __('site.price_high_low') }}</option>
                            </select>
                        </div>

                        <!-- Search (hidden but usable) -->
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                <!-- Sort Bar -->
                <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <p class="text-gray-600">{{ trans_choice('site.showing_products', $products->count(), ['count' => $products->count()]) }}</p>
                </div>

                @if($products->count() > 0)
                    <!-- Product Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-12">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="mt-12 pt-8 border-t border-blush-100">
                            {{ $products->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">{{ __('site.no_products_found') }}</p>
                        <p class="text-gray-400 mt-2">{{ __('site.try_adjust_filters') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<script>
    // Filter form submission
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Add your filter logic here
        console.log('Filters applied');
    });

    // Clear filters
    document.getElementById('filterForm').addEventListener('reset', function() {
        console.log('Filters cleared');
    });
</script>

</x-app-layout>