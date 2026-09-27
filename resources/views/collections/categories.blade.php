<x-app-layout>
<div class="min-h-screen bg-white">
    <!-- Breadcrumb -->
    <div class="bg-blush-50 border-b border-blush-100 py-4">
        <div class="container-centered">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <a href="/" class="hover:text-blush-500 transition-colors">{{ __('ui.collections.categories.home') }}</a>
                <span class="text-gray-400">/</span>
                <span class="text-charcoal font-medium">{{ __('ui.collections.categories.collections') }}</span>
            </div>
        </div>
    </div>

    <!-- Page Header -->
    <div class="bg-gradient-to-b from-blush-50 to-white py-16 border-b border-blush-100">
        <div class="container-centered text-center">
            <h1 class="text-5xl md:text-6xl font-serif font-bold text-charcoal mb-4">{{ __('ui.collections.categories.our_collections') }}</h1>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">{{ __('ui.collections.categories.explore_our_curated_jewelry_collections_each_designed_to_cel') }}</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-centered py-16">
        <!-- Collections Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            @forelse($categories as $category)
                <a href="{{ route('collections.show', $category->slug) }}" class="group">
                    <div class="relative overflow-hidden rounded-3xl h-96 bg-gradient-to-br from-blush-100 to-blush-50 shadow-soft hover:shadow-lg transition-all duration-300 mb-6">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blush-200 to-blush-100">
                                <span class="text-blush-400 text-6xl">✨</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-charcoal/60 via-charcoal/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    
                    <div class="text-center">
                        <h2 class="text-3xl font-serif font-bold text-charcoal mb-3 group-hover:text-blush-500 transition-colors">{{ $category->name }}</h2>
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $category->description ?? 'Explore this exquisite collection.' }}</p>
                        
                        <div class="inline-block bg-blush-50 rounded-full px-4 py-2 mb-6">
                            <span class="text-sm font-semibold text-charcoal">{{ $category->products_count }} {{ Str::plural('item', $category->products_count) }}</span>
                        </div>
                        
                        <div class="inline-flex items-center gap-2 text-blush-500 font-semibold group-hover:gap-3 transition-all">
                            {{ __('ui.collections.categories.explore_now') }}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-16">
                    <p class="text-gray-500 text-lg">{{ __('ui.collections.categories.no_collections_found') }}</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-blush-500 to-rose-gold py-16 mt-16">
        <div class="container-centered text-center text-white">
            <h2 class="text-3xl font-serif font-bold mb-4">{{ __('ui.collections.categories.can_t_find_what_you_re_looking_for') }}</h2>
            <p class="mb-6 text-blush-50">{{ __('ui.collections.categories.our_jewelry_experts_can_help_you_create_a_custom_piece_that_') }}</p>
            <a href="#" class="inline-block bg-white text-blush-500 px-8 py-3 rounded-lg font-semibold hover:bg-blush-50 transition-colors">{{ __('ui.collections.categories.request_custom_design') }}</a>
        </div>
    </div>
</div>
</x-app-layout>
