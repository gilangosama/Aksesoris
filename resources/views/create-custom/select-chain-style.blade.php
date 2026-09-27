<x-app-layout>
<div class="min-h-screen bg-gradient-to-b from-white to-blush-50 pt-32 pb-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Indicator -->
        <div class="flex justify-center items-center gap-1 sm:gap-2 mb-12 overflow-x-auto pb-2">
            <a href="{{ route('create-custom.type') }}" class="flex items-center gap-1 sm:gap-2 group flex-shrink-0">
                <button class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blush-500 text-white font-semibold text-xs sm:text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">1</button>
            </a>
            <div class="w-6 sm:w-8 h-1 bg-blush-500 flex-shrink-0"></div>
            <a href="{{ route('create-custom.finish', ['type' => $type]) }}" class="flex items-center gap-1 sm:gap-2 group flex-shrink-0">
                <button class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blush-500 text-white font-semibold text-xs sm:text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">2</button>
            </a>
            <div class="w-6 sm:w-8 h-1 bg-blush-500 flex-shrink-0"></div>
            <div class="flex items-center gap-1 sm:gap-2 flex-shrink-0">
                <button class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blush-500 text-white font-semibold text-xs sm:text-sm flex items-center justify-center shadow-soft">3</button>
            </div>
            <div class="w-6 sm:w-8 h-1 bg-blush-500 flex-shrink-0"></div>
            <div class="flex items-center gap-1 sm:gap-2 flex-shrink-0">
                <button class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blush-500 text-white font-semibold text-xs sm:text-sm flex items-center justify-center shadow-soft">4</button>
            </div>
            <div class="w-6 sm:w-8 h-1 bg-blush-200 flex-shrink-0"></div>
            <div class="flex items-center gap-1 sm:gap-2 flex-shrink-0">
                <button class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blush-100 text-charcoal font-semibold text-xs sm:text-sm flex items-center justify-center border-2 border-blush-200">5</button>
            </div>
        </div>

        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-serif font-bold text-charcoal mb-3">{{ __('ui.create_custom.select_chain_style.choose_your_chain_style') }}</h1>
            <p class="text-sm sm:text-base text-gray-600">{{ __('ui.create_custom.select_chain_style.select_the_perfect_chain_style_for_your') }} {{ strtolower(str_replace('_', ' ', $type)) }}</p>
        </div>

        <!-- Chain Styles Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-6 mb-12">
            @foreach($chainStyles as $chainStyle)
            <a href="{{ route('create-custom.chain-size', ['type' => $type, 'finish' => $finish, 'chain_style' => $chainStyle->id]) }}" class="group">
                <div class="relative bg-white rounded-2xl border-2 border-blush-100 overflow-hidden shadow-soft hover:shadow-2xl transition-all duration-300 transform hover:scale-105 cursor-pointer h-80">
                    <!-- Image Container -->
                    <div class="w-full h-full bg-gradient-to-br from-blush-50 to-white flex items-center justify-center group-hover:bg-gradient-to-br group-hover:from-rise-gold/5">
                        @if($chainStyle->image)
                            <img src="{{ Storage::url($chainStyle->image) }}" alt="{{ $chainStyle->name }}" class="w-72 h-72 object-contain">
                        @else
                            <div class="text-8xl text-blush-300">⛓️</div>
                        @endif
                    </div>

                    <!-- Arrow indicator -->
                    <div class="absolute top-6 right-6 w-10 h-10 rounded-full bg-rose-gold shadow-lg flex items-center justify-center group-hover:bg-rose-gold text-white group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Back Button -->
        <div class="flex justify-center">
            <a href="{{ route('create-custom.finish', ['type' => $type]) }}" class="inline-flex items-center gap-2 text-blush-600 hover:text-blush-700 font-semibold transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('ui.create_custom.select_chain_style.back_to_finish_selection') }}
            </a>
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
