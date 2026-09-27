<x-app-layout>
<div class="min-h-screen bg-gradient-to-b from-white to-blush-50 pt-32 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Indicator -->
        <div class="flex justify-center items-center gap-2 sm:gap-4 mb-12 overflow-x-auto pb-2">
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft">1</button>
            </div>
            <div class="w-8 sm:w-12 h-1 bg-blush-200 flex-shrink-0"></div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-100 text-charcoal font-semibold text-sm flex items-center justify-center border-2 border-blush-200">2</button>
            </div>
            <div class="w-8 sm:w-12 h-1 bg-blush-200 flex-shrink-0"></div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-100 text-charcoal font-semibold text-sm flex items-center justify-center border-2 border-blush-200">3</button>
            </div>
            <div class="w-8 sm:w-12 h-1 bg-blush-200 flex-shrink-0"></div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-100 text-charcoal font-semibold text-sm flex items-center justify-center border-2 border-blush-200">4</button>
            </div>
            <div class="w-8 sm:w-12 h-1 bg-blush-200 flex-shrink-0"></div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-100 text-charcoal font-semibold text-sm flex items-center justify-center border-2 border-blush-200">5</button>
            </div>
        </div>

        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-3xl sm:text-4xl font-serif font-bold text-charcoal mb-3">{{ __('ui.create_custom.select_type.choose_jewelry_type') }}</h1>
            <p class="text-base text-gray-600 max-w-2xl mx-auto">{{ __('ui.create_custom.select_type.select_the_type_of_jewelry_you_d_like_to_create_each_piece_c') }}</p>
        </div>

        <!-- Jewelry Types Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($types as $typeKey => $typeData)
            <a href="{{ route('create-custom.finish', ['type' => $typeKey]) }}" class="group flex flex-col h-full">
                <div class="relative flex-1 rounded-t-2xl overflow-hidden shadow-soft hover:shadow-lg transition-all duration-300 bg-gradient-to-br from-blush-50 to-blush-100 min-h-[200px]">
                    <!-- Product Image -->
                    @if($typeData['image'] && trim($typeData['image']) !== '')
                    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('storage/' . $typeData['image']) }}'); background-position: center;"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                    @else
                    <!-- Fallback Pattern -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-6xl opacity-10">💎</div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-br from-blush-100 via-blush-50 to-rose-gold/5"></div>
                    @endif

                    <!-- Price Badge -->
                    <div class="absolute top-4 right-4 bg-rose-gold text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg z-10">
                        {{ __('ui.create_custom.select_type.from_rp') }} {{ number_format($typeData['price'], 0, ',', '.') }}
                    </div>
                </div>

                <!-- Content Section -->
                <div class="bg-white rounded-b-2xl p-6 border border-t-0 border-blush-100 shadow-soft hover:shadow-lg transition-all duration-300 flex flex-col justify-between flex-1">
                    <!-- Type Name -->
                    <div class="mb-3">
                        <h3 class="text-lg font-serif font-bold text-charcoal">{{ $typeData['label'] }}</h3>
                    </div>
                    
                    <!-- Description -->
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2 flex-grow">{{ $typeData['description'] }}</p>
                    
                    <!-- Arrow indicator -->
                    <div class="flex items-center justify-between pt-3 border-t border-blush-100">
                        <span class="text-xs font-semibold text-rose-gold">{{ __('ui.create_custom.select_type.select_type') }}</span>
                        <div class="w-6 h-6 rounded-full bg-blush-100 flex items-center justify-center group-hover:bg-rose-gold text-charcoal group-hover:text-white transition-colors duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Additional Info Section -->
        <div class="bg-white rounded-2xl border border-blush-100 p-8 shadow-soft">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blush-100">
                            <svg class="h-6 w-6 text-rose-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-base font-semibold text-charcoal">{{ __('ui.create_custom.select_type.fully_customizable') }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ __('ui.create_custom.select_type.choose_style_material_and_add_personalized_details') }}</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blush-100">
                            <svg class="h-6 w-6 text-rose-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-base font-semibold text-charcoal">{{ __('ui.create_custom.select_type.expert_crafted') }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ __('ui.create_custom.select_type.our_artisans_will_bring_your_design_to_life_with_precision') }}</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blush-100">
                            <svg class="h-6 w-6 text-rose-gold" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-base font-semibold text-charcoal">{{ __('ui.create_custom.select_type.quick_process') }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ __('ui.create_custom.select_type.get_your_custom_piece_in_just_a_few_simple_steps') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
</x-app-layout>
