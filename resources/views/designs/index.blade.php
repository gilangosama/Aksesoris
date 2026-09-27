<x-app-layout>
    <div class="min-h-screen bg-white" x-data="{ consultationOpen: false }">
        
        <div class="bg-blush-50 border-b border-blush-100 py-4">
            <div class="container-centered">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <a href="/" class="hover:text-blush-500 transition-colors">{{ __('site.home') }}</a>
                    <span class="text-gray-400">/</span>
                    <span class="text-charcoal font-medium">{{ __('navigation.designs') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blush-500 via-blush-400 to-rose-gold py-20 lg:py-28 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20 animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-white/10 rounded-full blur-3xl -ml-20 -mb-20 animate-pulse delay-700"></div>
            
            <div class="container-centered relative z-10 text-center md:text-left">
                <div class="flex flex-col md:flex-row items-center justify-between gap-12">
                    <div class="max-w-2xl">
                        <span class="inline-block py-1 px-3 rounded-full bg-white/20 backdrop-blur-sm text-xs font-bold tracking-widest uppercase mb-4 border border-white/30">{{ __('site.bespoke_jewelry') }}</span>
                        <h1 class="text-5xl md:text-7xl font-serif font-bold mb-6 leading-tight">{{ __('site.craft_your_dream') }}</h1>
                        <p class="text-xl text-blush-50 mb-8 leading-relaxed max-w-lg">{{ __('site.custom_design_subheading') }}</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                            <button @click="consultationOpen = true" class="bg-white text-blush-600 px-8 py-4 rounded-full font-bold shadow-lg hover:bg-blush-50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                {{ __('ui.designs.index.start_your_design') }}
                            </button>
                            <a href="#portfolio" class="px-8 py-4 rounded-full font-bold border border-white/40 hover:bg-white/10 transition-colors flex items-center gap-2">
                                {{ __('ui.designs.index.view_portfolio') }}
                            </a>
                        </div>
                    </div>
                    <div class="hidden md:block relative">
                         <div class="w-64 h-64 border-4 border-white/20 rounded-full flex items-center justify-center relative">
                            <div class="absolute inset-0 border-4 border-white/40 rounded-full scale-110 opacity-50"></div>
                            <span class="font-serif text-4xl italic">{{ __('ui.designs.index.unique') }}</span>
                         </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white py-20">
            <div class="container-centered">
                <div class="text-center mb-16">
                    <span class="text-blush-500 font-bold tracking-widest text-xs uppercase">{{ __('site.how_it_works') }}</span>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold text-charcoal mt-2">{{ __('site.bespoke_process') }}</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                    <div class="hidden md:block absolute top-12 left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-blush-200 to-transparent z-0"></div>

                    <div class="relative z-10 text-center group">
                        <div class="w-24 h-24 mx-auto bg-white rounded-full border-4 border-blush-50 flex items-center justify-center mb-6 group-hover:border-blush-200 transition-colors shadow-sm">
                            <span class="text-3xl">💬</span>
                        </div>
                        <h3 class="font-serif font-bold text-charcoal text-xl mb-3">1. {{ __('site.consultation') }}</h3>
                        <p class="text-sm text-gray-500 leading-relaxed px-4">{{ __('site.custom_design_subheading') }}</p>
                    </div>

                    <div class="relative z-10 text-center group">
                        <div class="w-24 h-24 mx-auto bg-white rounded-full border-4 border-blush-50 flex items-center justify-center mb-6 group-hover:border-blush-200 transition-colors shadow-sm">
                            <span class="text-3xl">✏️</span>
                        </div>
                        <h3 class="font-serif font-bold text-charcoal text-xl mb-3">2. {{ __('site.sketch_3d') }}</h3>
                        <p class="text-sm text-gray-500 leading-relaxed px-4">{{ __('site.custom_design_subheading') }}</p>
                    </div>

                    <div class="relative z-10 text-center group">
                        <div class="w-24 h-24 mx-auto bg-white rounded-full border-4 border-blush-50 flex items-center justify-center mb-6 group-hover:border-blush-200 transition-colors shadow-sm">
                            <span class="text-3xl">💎</span>
                        </div>
                        <h3 class="font-serif font-bold text-charcoal text-xl mb-3">3. {{ __('site.crafting') }}</h3>
                        <p class="text-sm text-gray-500 leading-relaxed px-4">{{ __('site.custom_design_subheading') }}</p>
                    </div>

                    <div class="relative z-10 text-center group">
                        <div class="w-24 h-24 mx-auto bg-white rounded-full border-4 border-blush-50 flex items-center justify-center mb-6 group-hover:border-blush-200 transition-colors shadow-sm">
                            <span class="text-3xl">✨</span>
                        </div>
                        <h3 class="font-serif font-bold text-charcoal text-xl mb-3">4. {{ __('site.reveal') }}</h3>
                        <p class="text-sm text-gray-500 leading-relaxed px-4">{{ __('site.custom_design_subheading') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="portfolio" class="bg-gray-50 py-16 border-t border-blush-100">
            <div class="container-centered">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl p-6 shadow-soft sticky top-24">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="font-serif font-bold text-charcoal text-lg">{{ __('site.filter_portfolio') }}</h3>
                                <a href="{{ route('designs.index') }}" class="text-xs text-blush-500 hover:underline">{{ __('site.reset') }}</a>
                            </div>

                            <form action="{{ route('designs.index') }}" method="GET" class="space-y-8">
                                <div>
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">{{ __('site.jewelry_type') }}</h4>
                                    <div class="space-y-2">
                                        @foreach(['Ring', 'Necklace', 'Earring', 'Bracelet'] as $type)
                                            <label class="flex items-center cursor-pointer group">
                                                <input type="radio" name="type" value="{{ strtolower($type) }}" class="w-4 h-4 text-blush-600 focus:ring-blush-500 border-gray-300" {{ request('type') == strtolower($type) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-600 group-hover:text-blush-500 transition-colors">{{ $type }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">{{ __('site.style') }}</h4>
                                    <div class="space-y-2">
                                        @foreach(['Modern', 'Vintage', 'Classic', 'Bohemian'] as $style)
                                            <label class="flex items-center cursor-pointer group">
                                                <input type="checkbox" name="style[]" value="{{ strtolower($style) }}" class="rounded text-blush-600 focus:ring-blush-500 border-gray-300" {{ in_array(strtolower($style), (array)request('style')) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-600 group-hover:text-blush-500 transition-colors">{{ $style }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-charcoal text-white py-3 rounded-lg text-sm font-semibold hover:bg-black transition-colors">{{ __('site.apply_filters') }}</button>
                            </form>
                        </div>
                    </div>

                    <div class="lg:col-span-3">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="font-serif font-bold text-2xl text-charcoal">{{ __('site.design_gallery') }}</h2>
                            <span class="text-sm text-gray-500">{{ trans_choice('site.inspirations_found', $designs->count(), ['count' => $designs->count()]) }}</span>
                        </div>

                        @if($designs->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($designs as $design)
                                    <div class="group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                                        <div class="aspect-[4/3] overflow-hidden bg-gray-100 relative">
                                            @if($design->image)
                                                <img src="{{ asset('storage/' . $design->image) }}" alt="{{ $design->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                            @else
                                                 <div class="w-full h-full flex items-center justify-center bg-blush-50 text-blush-300">
                                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                                <button @click="consultationOpen = true; $dispatch('set-reference', '{{ $design->name }}')" class="bg-white text-charcoal px-6 py-2 rounded-full font-bold text-sm hover:bg-blush-50 transition-colors transform translate-y-4 group-hover:translate-y-0 duration-300">
                                                    {{ __('ui.designs.index.i_want_this_style') }}
                                                </button>
                                            </div>
                                        </div>

                                        <div class="p-5">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <p class="text-xs font-bold text-blush-500 uppercase tracking-wider">{{ $design->category ?? 'Custom' }}</p>
                                                    <h3 class="font-serif font-bold text-lg text-charcoal">{{ $design->name }}</h3>
                                                </div>
                                                <button class="text-gray-400 hover:text-red-500 transition-colors">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                                </button>
                                            </div>
                                            <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $design->description }}</p>
                                            <div class="flex gap-2">
                                                @foreach(explode(',', $design->tags ?? '') as $tag)
                                                    <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-1 rounded-md">{{ trim($tag) }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-12">
                                {{ $designs->links() }}
                            </div>
                        @else
                            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-300">
                                <p class="text-gray-500 text-lg">{{ __('site.no_designs_found') }}</p>
                                <a href="{{ route('designs.index') }}" class="text-blush-500 font-semibold mt-2 inline-block">{{ __('site.clear_filters') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div 
            x-show="consultationOpen" 
            style="display: none;"
            class="fixed inset-0 z-50 overflow-y-auto" 
            aria-labelledby="modal-title" 
            role="dialog" 
            aria-modal="true"
        >
            <div x-show="consultationOpen" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="consultationOpen = false"></div>

            <div x-show="consultationOpen" x-transition.scale.origin.bottom class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden relative z-10">
                    
                    <div class="bg-gradient-to-r from-blush-500 to-rose-gold p-6 text-white relative">
                        <button @click="consultationOpen = false" class="absolute top-4 right-4 text-white/80 hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                        <h3 class="font-serif font-bold text-2xl mb-1">{{ __('ui.designs.index.start_your_journey') }}</h3>
                        <p class="text-blush-50 text-sm">{{ __('ui.designs.index.tell_us_about_your_dream_piece') }}</p>
                    </div>

                    <form action="{{ route('designs.store_inquiry') }}" method="POST" class="p-6 md:p-8 space-y-5">
                        @csrf
                        
                        <div x-data="{ reference: '' }" @set-reference.window="reference = $event.detail">
                            <div x-show="reference" class="mb-4 p-3 bg-blush-50 rounded-lg flex items-center gap-2 text-sm text-blush-700">
                                <span class="font-bold">{{ __('ui.designs.index.reference') }}</span> <span x-text="reference"></span>
                                <input type="hidden" name="reference_design" :value="reference">
                                <button type="button" @click="reference = ''" class="ml-auto text-xs text-red-400 hover:text-red-600">{{ __('ui.designs.index.remove') }}</button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-charcoal mb-2">{{ __('ui.designs.index.jewelry_type') }}</label>
                            <select name="type" class="w-full border-gray-300 rounded-lg focus:ring-blush-500 focus:border-blush-500">
                                <option>{{ __('ui.designs.index.engagement_ring') }}</option>
                                <option>{{ __('ui.designs.index.wedding_band') }}</option>
                                <option>{{ __('ui.designs.index.necklace') }}</option>
                                <option>{{ __('ui.designs.index.earrings') }}</option>
                                <option>{{ __('ui.designs.index.other') }}</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-charcoal mb-2">{{ __('ui.designs.index.budget_range') }}</label>
                                <select name="budget" class="w-full border-gray-300 rounded-lg focus:ring-blush-500 focus:border-blush-500">
                                    <option value="7500000-15000000">{{ __('ui.designs.index.rp_7_500_000_15_000_000') }}</option>
                                    <option value="15000000-37500000">{{ __('ui.designs.index.rp_15_000_000_37_500_000') }}</option>
                                    <option value="37500000-75000000">{{ __('ui.designs.index.rp_37_500_000_75_000_000') }}</option>
                                    <option value="75000000+">{{ __('ui.designs.index.rp_75_000_000') }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-charcoal mb-2">{{ __('ui.designs.index.material_preference') }}</label>
                                <select name="material" class="w-full border-gray-300 rounded-lg focus:ring-blush-500 focus:border-blush-500">
                                    <option>{{ __('ui.designs.index.18k_yellow_gold') }}</option>
                                    <option>{{ __('ui.designs.index.18k_white_gold') }}</option>
                                    <option>{{ __('ui.designs.index.rose_gold') }}</option>
                                    <option>{{ __('ui.designs.index.platinum') }}</option>
                                    <option>{{ __('ui.designs.index.not_sure') }}</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-charcoal mb-2">{{ __('ui.designs.index.description') }}</label>
                            <textarea name="description" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-blush-500 focus:border-blush-500" placeholder="{{ __('ui.designs.index.describe_your_idea_style_preferences_or_any_specific_details') }}"></textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full btn-primary py-3 rounded-lg font-bold shadow-lg">
                                {{ __('ui.designs.index.submit_inquiry') }}
                            </button>
                            <p class="text-xs text-gray-400 text-center mt-3">{{ __('ui.designs.index.our_team_will_contact_you_within_24_hours') }}</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>