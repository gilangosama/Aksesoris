<x-app-layout>
<div class="min-h-screen bg-gradient-to-b from-white to-blush-50 pt-32 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Indicator -->
        <div class="flex justify-center items-center gap-2 sm:gap-4 mb-12 overflow-x-auto pb-2">
            <a href="{{ route('create-custom.type') }}" class="flex items-center gap-2 group flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">1</button>
            </a>
            <div class="w-8 sm:w-12 h-1 bg-blush-500 flex-shrink-0"></div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft">2</button>
            </div>
            <div class="w-8 sm:w-12 h-1 bg-blush-200 flex-shrink-0"></div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-100 text-charcoal font-semibold text-sm flex items-center justify-center border-2 border-blush-200">3</button>
            </div>
            <div class="w-8 sm:w-12 h-1 bg-blush-200 flex-shrink-0"></div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-100 text-charcoal font-semibold text-sm flex items-center justify-center border-2 border-blush-200">4</button>
            </div>
        </div>

        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-charcoal mb-3">{{ __('ui.create_custom.select_finish.select_finish') }}</h1>
            <p class="text-base text-gray-600">{{ __('ui.create_custom.select_finish.choose_your_preferred_chain_finish') }}</p>
        </div>

        <!-- Finish Options -->
        <div class="bg-white rounded-2xl border-2 border-charcoal p-8 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($finishes as $finishKey => $finishData)
                <a href="{{ route('create-custom.chain-style', ['type' => $type, 'finish' => $finishKey]) }}" class="group">
                    <div class="relative h-64 rounded-xl overflow-hidden shadow-soft hover:shadow-lg transition-all duration-300 transform hover:scale-105 cursor-pointer bg-gradient-to-br from-white to-blush-50 border border-blush-100 p-6 flex flex-col items-center justify-center text-center">
                        <!-- Background Accent -->
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-rose-gold/10 to-blush-200/10 rounded-full -mr-12 -mt-12"></div>
                        
                        <!-- Content -->
                        <div class="relative z-10">
                            <!-- Finish Icon/Visual -->
                            <div class="mb-4">
                                @if($finishKey === 'silver')
                                    <div class="w-20 h-12 rounded-full bg-gradient-to-br from-gray-200 to-gray-400 shadow-lg mx-auto"></div>
                                @else
                                    <div class="w-20 h-12 rounded-full bg-gradient-to-br from-yellow-300 to-yellow-500 shadow-lg mx-auto"></div>
                                @endif
                            </div>
                            
                            <!-- Finish Name -->
                            <h3 class="text-xl font-serif font-bold text-charcoal mb-2">{{ $finishData['label'] }}</h3>
                            
                            <!-- Description -->
                            <p class="text-sm text-gray-600">{{ $finishData['description'] }}</p>
                        </div>
                        
                        <!-- Arrow indicator -->
                        <div class="absolute bottom-4 right-4 w-8 h-8 rounded-full bg-blush-100 flex items-center justify-center group-hover:bg-rose-gold text-charcoal group-hover:text-white transition-colors duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Back Button -->
        <div class="flex justify-center">
            <a href="{{ route('create-custom.type') }}" class="inline-flex items-center gap-2 text-blush-600 hover:text-blush-700 font-semibold transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('ui.create_custom.select_finish.back_to_type_selection') }}
            </a>
        </div>
    </div>
</div>
</x-app-layout>
