<x-app-layout>
<div class="min-h-screen bg-gradient-to-b from-white to-blush-50 pt-32 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Indicator -->
        <div class="flex justify-center items-center gap-2 sm:gap-4 mb-12 overflow-x-auto pb-2">
            <a href="{{ route('create-custom.type') }}" class="flex items-center gap-2 group flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">1</button>
                <span class="text-xs font-semibold text-gray-400 hidden sm:inline">{{ __('ui.create_custom.select_style.type') }}</span>
            </a>
            <div class="w-8 sm:w-12 h-1 bg-blush-500 flex-shrink-0"></div>
            <a href="{{ route('create-custom.finish', ['type' => $type]) }}" class="flex items-center gap-2 group flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">2</button>
                <span class="text-xs font-semibold text-gray-400 hidden sm:inline">{{ __('ui.create_custom.select_style.finish') }}</span>
            </a>
            <div class="w-8 sm:w-12 h-1 bg-blush-500 flex-shrink-0"></div>
            <a href="{{ route('create-custom.chain-style', ['type' => $type, 'finish' => $finish]) }}" class="flex items-center gap-2 group flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">3</button>
                <span class="text-xs font-semibold text-gray-400 hidden sm:inline">{{ __('ui.create_custom.select_style.chain') }}</span>
            </a>
            <div class="w-8 sm:w-12 h-1 bg-blush-500 flex-shrink-0"></div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft">4</button>
                <span class="text-xs font-semibold text-charcoal hidden sm:inline">{{ __('ui.create_custom.select_style.style') }}</span>
            </div>
            <div class="w-8 sm:w-12 h-1 bg-blush-200 flex-shrink-0"></div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-100 text-charcoal font-semibold text-sm flex items-center justify-center border-2 border-blush-200">5</button>
                <span class="text-xs font-semibold text-gray-400 hidden sm:inline">{{ __('ui.create_custom.select_style.material') }}</span>
            </div>
            <div class="w-8 sm:w-12 h-1 bg-blush-200 flex-shrink-0"></div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-100 text-charcoal font-semibold text-sm flex items-center justify-center border-2 border-blush-200">6</button>
                <span class="text-xs font-semibold text-gray-400 hidden sm:inline">{{ __('ui.create_custom.select_style.details') }}</span>
            </div>
        </div>

        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-3xl sm:text-4xl font-serif font-bold text-charcoal mb-3">{{ __('ui.create_custom.select_style.choose_your_style') }}</h1>
            <p class="text-base text-gray-600">{{ __('ui.create_custom.select_style.select_the_style_that_best_matches_your_personality') }}</p>
        </div>

        <!-- Styles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            @foreach($styles as $styleKey => $styleLabel)
            <a href="{{ route('create-custom.material', ['type' => $type, 'finish' => $finish, 'chain_style' => $chain_style, 'style' => $styleKey]) }}" class="group">
                <div class="relative h-48 rounded-2xl overflow-hidden shadow-soft hover:shadow-lg transition-all duration-300 transform hover:scale-105 cursor-pointer bg-gradient-to-br from-white to-blush-50 border border-blush-100">
                    <!-- Background Accent -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-rose-gold/10 to-blush-200/10 rounded-full -mr-16 -mt-16"></div>
                    
                    <!-- Content -->
                    <div class="relative h-full flex flex-col items-center justify-center p-6 text-center">
                        <!-- Style Icon -->
                        <div class="text-4xl mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            @if($styleKey === 'modern')
                                ✨
                            @elseif($styleKey === 'vintage')
                                🕰️
                            @elseif($styleKey === 'classic')
                                👑
                            @else
                                🌿
                            @endif
                        </div>
                        
                        <!-- Style Name -->
                        <h3 class="text-2xl font-serif font-bold text-charcoal">{{ $styleLabel }}</h3>
                        
                        <!-- Arrow indicator -->
                        <div class="absolute bottom-4 right-4 w-8 h-8 rounded-full bg-blush-100 flex items-center justify-center group-hover:bg-rose-gold text-charcoal group-hover:text-white transition-colors duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Back Button -->
        <div class="flex justify-center">
            <a href="{{ route('create-custom.chain-style', ['type' => $type, 'finish' => $finish]) }}" class="inline-flex items-center gap-2 text-blush-600 hover:text-blush-700 font-semibold transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('ui.create_custom.select_style.back_to_finish_selection') }}
            </a>
        </div>
    </div>
</div>
</x-app-layout>
