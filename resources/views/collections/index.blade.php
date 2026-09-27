<x-app-layout>
    <div class="min-h-screen bg-white">
        <!-- Breadcrumb -->
        <div class="bg-blush-50 border-b border-blush-100 py-4">
            <div class="container-centered">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <a href="/" class="hover:text-blush-500 transition-colors">{{ __('site.home') }}</a>
                    <span class="text-gray-400">/</span>
                    <a href="{{ route('collections.index') }}" class="hover:text-blush-500 transition-colors">{{ __('navigation.collections') }}</a>
                    <span class="text-gray-400">/</span>
                    <span class="text-charcoal font-medium">{{ $category->name }}</span>
                </div>
            </div>
        </div>

        <!-- Page Header -->
        <div class="bg-gradient-to-b from-blush-50 to-white py-12 border-b border-blush-100">
            <div class="container-centered text-center">
                <h1 class="text-4xl md:text-5xl font-serif font-bold text-charcoal mb-4">{{ $category->name }}</h1>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ $category->description ?? __('site.explore_collection') }}</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container-centered py-12">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar Filters -->
                <div class="lg:col-span-1">
                    <div class="bg-blush-50 rounded-2xl p-6 sticky top-24">
                        <h3 class="font-serif font-bold text-charcoal text-lg mb-6">{{ __('site.filters') }}</h3>

                        <form action="{{ route('collections.show', $category->slug) }}" method="GET" class="space-y-6">
                            <!-- Price Range Filter -->
                            <div>
                                <label class="text-sm font-semibold text-charcoal mb-3 block">{{ __('ui.collections.index.price_range') }}</label>
                                <div class="space-y-2">
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="price_range" value="" class="w-4 h-4 accent-blush-500" {{ !request('price_range') ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700 group-hover:text-blush-500 transition-colors">{{ __('site.all_categories') }}</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="price_range" value="0-7500000" class="w-4 h-4 accent-blush-500" {{ request('price_range') === '0-7500000' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700 group-hover:text-blush-500 transition-colors">{{ __('ui.collections.index.rp_0_7_500_000') }}</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="price_range" value="7500000-22500000" class="w-4 h-4 accent-blush-500" {{ request('price_range') === '7500000-22500000' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700 group-hover:text-blush-500 transition-colors">{{ __('ui.collections.index.rp_7_500_000_22_500_000') }}</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="price_range" value="22500000-45000000" class="w-4 h-4 accent-blush-500" {{ request('price_range') === '22500000-45000000' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700 group-hover:text-blush-500 transition-colors">{{ __('ui.collections.index.rp_22_500_000_45_000_000') }}</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="price_range" value="45000000+" class="w-4 h-4 accent-blush-500" {{ request('price_range') === '45000000+' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700 group-hover:text-blush-500 transition-colors">{{ __('ui.collections.index.rp_45_000_000') }}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="border-t border-blush-200"></div>

                            <div class="flex gap-2 pt-2">
                                <button type="submit" class="flex-1 bg-blush-500 hover:bg-blush-600 text-white py-2 rounded-lg text-sm font-semibold transition-colors">{{ __('site.apply') }}</button>
                                <a href="{{ route('collections.show', $category->slug) }}" class="flex-1 border border-blush-300 text-blush-500 hover:bg-blush-50 py-2 rounded-lg text-sm font-semibold transition-colors text-center">{{ __('site.clear') }}</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Collections Grid -->
                <div class="lg:col-span-3">
                    <!-- Sort & View Options -->
                    <div class="flex items-center justify-between mb-8">
                        <p class="text-sm text-gray-600">{{ trans_choice('site.showing_products', $products->count(), ['count' => $products->count()]) }}</p>
                        <form method="GET" action="{{ route('collections.show', $category->slug) }}" class="flex items-center gap-2">
                            @if(request('price_range'))
                                <input type="hidden" name="price_range" value="{{ request('price_range') }}">
                            @endif
                            <select name="sort" onchange="this.form.submit()" class="border border-blush-200 rounded-lg px-3 py-2 text-sm text-gray-700 hover:border-blush-300 focus:outline-none focus:ring-2 focus:ring-blush-500 focus:ring-opacity-20">
                                <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>{{ __('site.latest') }}</option>
                                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>{{ __('ui.collections.index.most_popular') }}</option>
                                <option value="price-low" {{ request('sort') === 'price-low' ? 'selected' : '' }}>{{ __('site.price_low_high') }}</option>
                                <option value="price-high" {{ request('sort') === 'price-high' ? 'selected' : '' }}>{{ __('site.price_high_low') }}</option>
                            </select>
                        </form>
                    </div>

                    @if($products->count() > 0)
                        <!-- Products Grid -->
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
                        <div class="text-center py-16">
                            <p class="text-gray-500 text-lg">{{ __('site.no_products_found') }}</p>
                            <p class="text-gray-400 mt-2">{{ __('site.try_adjust_filters') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-gradient-to-r from-blush-500 to-rose-gold py-16 mt-16">
            <div class="container-centered text-center text-white">
                <h2 class="text-3xl font-serif font-bold mb-4">{{ __('site.cant_find') }}</h2>
                <p class="mb-6 text-blush-50">{{ __('site.custom_design_help') }}</p>
                <a href="#" class="inline-block bg-white text-blush-500 px-8 py-3 rounded-lg font-semibold hover:bg-blush-50 transition-colors">{{ __('site.request_custom_design') }}</a>
            </div>
        </div>
    </div>
</x-app-layout>
