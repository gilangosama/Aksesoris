<x-app-layout>
<div class="min-h-screen bg-gradient-to-b from-white to-blush-50 pt-32 pb-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Indicator -->
        <div class="flex justify-center items-center gap-2 sm:gap-4 mb-12 overflow-x-auto pb-2">
            <a href="{{ route('create-custom.type') }}" class="flex items-center gap-2 group flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">1</button>
            </a>
            <div class="w-8 sm:w-12 h-1 bg-blush-500 flex-shrink-0"></div>
            <a href="{{ route('create-custom.finish', ['type' => $type]) }}" class="flex items-center gap-2 group flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">2</button>
            </a>
            <div class="w-8 sm:w-12 h-1 bg-blush-500 flex-shrink-0"></div>
            <a href="{{ route('create-custom.chain-style', ['type' => $type, 'finish' => $finish]) }}" class="flex items-center gap-2 group flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">3</button>
            </a>
            <div class="w-8 sm:w-12 h-1 bg-blush-500 flex-shrink-0"></div>
            <a href="{{ route('create-custom.charm', ['type' => $type, 'finish' => $finish, 'chain_style' => $chain_style]) }}" class="flex items-center gap-2 group flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">4</button>
            </a>
            <div class="w-8 sm:w-12 h-1 bg-blush-500 flex-shrink-0"></div>
            <a href="{{ route('create-custom.material', ['type' => $type, 'finish' => $finish, 'chain_style' => $chain_style, 'charm' => $charm]) }}" class="flex items-center gap-2 group flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">5</button>
            </a>
            <div class="w-8 sm:w-12 h-1 bg-blush-500 flex-shrink-0"></div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft">6</button>
                <span class="text-xs font-semibold text-charcoal hidden sm:inline">{{ __(\'ui.create_custom.details.details') }}/span>
            </div>
        </div>

        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-3xl sm:text-4xl font-serif font-bold text-charcoal mb-3">{{ __(\'ui.create_custom.details.add_your_details') }}/h1>
            <p class="text-base text-gray-600">{{ __(\'ui.create_custom.details.tell_us_more_about_your_vision_and_budget') }}/p>
        </div>

        <!-- Selection Summary -->
        <div class="bg-white rounded-2xl border border-blush-100 p-6 mb-8 shadow-soft">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __(\'ui.create_custom.details.type') }}/p>
                    <p class="text-base md:text-lg font-serif font-bold text-charcoal capitalize">{{ str_replace('_', ' ', $type) }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __(\'ui.create_custom.details.finish') }}/p>
                    <p class="text-base md:text-lg font-serif font-bold text-charcoal capitalize">{{ $finish }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __(\'ui.create_custom.details.chain') }}/p>
                    <p class="text-base md:text-lg font-serif font-bold text-charcoal capitalize text-sm">{{ $chain_style }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __(\'ui.create_custom.details.charm') }}/p>
                    <p class="text-base md:text-lg font-serif font-bold text-charcoal capitalize text-sm">{{ $charm }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">{{ __(\'ui.create_custom.details.material') }}/p>
                    <p class="text-base md:text-lg font-serif font-bold text-charcoal capitalize">{{ str_replace('_', ' ', $material) }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('create-custom.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Hidden Fields for Selection -->
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="finish" value="{{ $finish }}">
            <input type="hidden" name="chain_style" value="{{ $chain_style }}">
            <input type="hidden" name="charm" value="{{ $charm }}">
            <input type="hidden" name="material" value="{{ $material }}">

            <!-- Description Field -->
            <div>
                <label for="description" class="block text-sm font-semibold text-charcoal mb-3">
                    {{ __('ui.create_custom.details.describe_your_vision') }}
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="5"
                    placeholder="{{ __(\'ui.create_custom.details.tell_us_about_your_custom_design_any_specific_features_gemst') }}
                    class="w-full px-4 py-3 rounded-xl border border-blush-200 focus:border-rose-gold focus:ring-2 focus:ring-rose-gold/20 outline-none transition-colors duration-300 resize-none"
                ></textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Budget Field -->
            <div>
                <label for="budget" class="block text-sm font-semibold text-charcoal mb-3">
                    {{ __('ui.create_custom.details.budget_optional') }}
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-600 font-semibold">{{ __(\'ui.create_custom.details.rp') }}/span>
                    <input 
                        type="number" 
                        id="budget" 
                        name="budget" 
                        placeholder="0"
                        min="0"
                        step="100000"
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-blush-200 focus:border-rose-gold focus:ring-2 focus:ring-rose-gold/20 outline-none transition-colors duration-300"
                    >
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ __(\'ui.create_custom.details.leave_empty_if_you_prefer_a_custom_quote') }}/p>
                @error('budget')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6">
                <a href="{{ route('create-custom.material', ['type' => $type, 'finish' => $finish, 'chain_style' => $chain_style, 'style' => $style]) }}" class="flex-1 px-6 py-3 rounded-full border-2 border-blush-300 text-charcoal font-semibold hover:bg-blush-50 transition-colors duration-300 text-center">
                    {{ __('ui.create_custom.details.back') }}
                </a>
                <button type="submit" class="flex-1 btn-primary py-3 rounded-full font-semibold">
                    {{ __('ui.create_custom.details.submit_request') }}
                </button>
            </div>
        </form>

        <!-- Info Box -->
        <div class="mt-12 bg-blush-50 rounded-2xl border border-blush-200 p-6">
            <h3 class="font-semibold text-charcoal mb-3">{{ __(\'ui.create_custom.details.what_happens_next') }}/h3>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex gap-3">
                    <span class="text-rose-gold font-bold">✓</span>
                    <span>{{ __(\'ui.create_custom.details.our_design_team_will_review_your_request_and_reach_out_withi') }}/span>
                </li>
                <li class="flex gap-3">
                    <span class="text-rose-gold font-bold">✓</span>
                    <span>{{ __(\'ui.create_custom.details.we_ll_provide_a_custom_quote_and_discuss_any_adjustments_to_') }}/span>
                </li>
                <li class="flex gap-3">
                    <span class="text-rose-gold font-bold">✓</span>
                    <span>{{ __(\'ui.create_custom.details.once_approved_your_piece_will_be_crafted_with_meticulous_att') }}/span>
                </li>
                <li class="flex gap-3">
                    <span class="text-rose-gold font-bold">✓</span>
                    <span>{{ __(\'ui.create_custom.details.you_ll_receive_updates_on_the_progress_of_your_custom_creati') }}/span>
                </li>
            </ul>
        </div>

        <!-- {{ __('ui.create_custom.details.back') }} Button -->
        <div class="flex justify-center mt-8">
            <a href="{{ route('create-custom.material', ['type' => $type, 'finish' => $finish, 'chain_style' => $chain_style, 'charm' => $charm]) }}" class="inline-flex items-center gap-2 text-blush-600 hover:text-blush-700 font-semibold transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
                {{ __('ui.create_custom.details.back') }} to Material Selection
            </a>
        </div>
    </div>
</div>
</x-app-layout>
