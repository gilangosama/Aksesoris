<x-app-layout>
    <div class="min-h-screen bg-gray-50 pt-24 pb-16" x-data="{ activeTab: 'profile' }">
        <div class="container-centered px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10">
                <h1 class="text-3xl md:text-4xl font-serif font-bold text-charcoal">{{ __('ui.profile.edit.my_account') }}</h1>
                <p class="text-gray-500 mt-2">{{ __('ui.profile.edit.manage_your_personal_information_address_book_and_security_s') }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                
                <aside class="lg:col-span-4 space-y-6">
                    <div class="bg-white p-6 rounded-3xl shadow-soft border border-blush-50 flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blush-400 to-rose-gold flex items-center justify-center text-white font-serif text-2xl shadow-md">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <h3 class="text-lg font-serif font-bold text-charcoal truncate">{{ auth()->user()->name }}</h3>
                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            <span class="inline-block mt-1 text-[10px] font-bold uppercase tracking-widest text-blush-600 bg-blush-50 px-2 py-0.5 rounded-full">
                                {{ __('ui.profile.edit.member') }}
                            </span>
                        </div>
                    </div>

                    <nav class="bg-white rounded-3xl shadow-soft border border-blush-50 overflow-hidden">
                        <button 
                            @click="activeTab = 'profile'" 
                            :class="activeTab === 'profile' ? 'bg-blush-50 text-blush-600 border-l-4 border-blush-500' : 'text-gray-600 hover:bg-gray-50 border-l-4 border-transparent'"
                            class="w-full text-left px-6 py-4 font-medium transition-all flex items-center gap-3"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ __('ui.profile.edit.profile_information') }}
                        </button>

                        <button 
                            @click="activeTab = 'addresses'" 
                            :class="activeTab === 'addresses' ? 'bg-blush-50 text-blush-600 border-l-4 border-blush-500' : 'text-gray-600 hover:bg-gray-50 border-l-4 border-transparent'"
                            class="w-full text-left px-6 py-4 font-medium transition-all flex items-center gap-3"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ __('ui.profile.edit.address_book') }}
                        </button>

                        <button 
                            @click="activeTab = 'orders'" 
                            :class="activeTab === 'orders' ? 'bg-blush-50 text-blush-600 border-l-4 border-blush-500' : 'text-gray-600 hover:bg-gray-50 border-l-4 border-transparent'"
                            class="w-full text-left px-6 py-4 font-medium transition-all flex items-center gap-3"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            {{ __('ui.profile.edit.my_transactions') }}
                        </button>

                        <button 
                            @click="activeTab = 'security'" 
                            :class="activeTab === 'security' ? 'bg-blush-50 text-blush-600 border-l-4 border-blush-500' : 'text-gray-600 hover:bg-gray-50 border-l-4 border-transparent'"
                            class="w-full text-left px-6 py-4 font-medium transition-all flex items-center gap-3"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            {{ __('ui.profile.edit.security_password') }}
                        </button>

                        <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100">
                            @csrf
                            <button type="submit" class="w-full text-left px-6 py-4 font-medium text-red-500 hover:bg-red-50 transition-all flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                {{ __('ui.profile.edit.log_out') }}
                            </button>
                        </form>
                    </nav>
                </aside>

                <main class="lg:col-span-8 space-y-6">
                    
                    <div x-show="activeTab === 'profile'" x-transition.opacity class="bg-white p-6 sm:p-8 rounded-3xl shadow-soft border border-blush-50">
                        <h2 class="text-xl font-serif font-bold text-charcoal mb-6">{{ __('ui.profile.edit.personal_information') }}</h2>
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div x-show="activeTab === 'addresses'" x-transition.opacity style="display: none;">
                        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-soft border border-blush-50">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-xl font-serif font-bold text-charcoal">{{ __('ui.profile.edit.address_book') }}</h2>
                                <button onclick="document.getElementById('address-modal').classList.remove('hidden')" class="text-sm font-semibold text-blush-600 hover:text-blush-700">
                                    {{ __('ui.profile.edit.add_new') }}
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @forelse(auth()->user()->addresses as $address)
                                    <div class="relative p-5 border border-gray-200 rounded-2xl hover:border-blush-300 hover:shadow-md transition-all group">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="font-semibold text-charcoal">{{ $address->recipent_name ?? auth()->user()->name }}</span>
                                            @if($address->is_default)
                                                <span class="text-[10px] uppercase font-bold text-white bg-blush-400 px-2 py-0.5 rounded-full">{{ __('ui.profile.edit.default') }}</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600 mb-1 h-10 line-clamp-2">{{ $address->address }}</p>
                                        <p class="text-sm text-gray-500 mb-3">{{ $address->city }}, {{ $address->postal_code }}</p>
                                        <p class="text-sm text-gray-500 mb-4">📞 {{ $address->phone }}</p>
                                        
                                        <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                                            <button class="text-xs font-semibold text-gray-500 hover:text-charcoal">{{ __('ui.profile.edit.edit') }}</button>
                                            <span class="text-gray-300">|</span>
                                            <form method="POST" action="{{ route('addresses.destroy', $address->id) }}" onsubmit="return confirm('Delete this address?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-semibold text-red-400 hover:text-red-600">{{ __('ui.profile.edit.delete') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-2 text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                        <p class="text-gray-500 mb-4">{{ __('ui.profile.edit.you_have_no_saved_addresses') }}</p>
                                        <button class="btn-primary px-6 py-2 rounded-lg text-sm">{{ __('ui.profile.edit.add_address') }}</button>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'orders'" x-transition.opacity style="display: none;">
                        <div class="bg-white p-8 rounded-3xl shadow-soft border border-blush-50 text-center py-16">
                            <div class="w-16 h-16 bg-blush-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-blush-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <h3 class="text-xl font-serif font-bold text-charcoal mb-2">{{ __('ui.profile.edit.transaction_history') }}</h3>
                            <p class="text-gray-500 mb-6">{{ __('ui.profile.edit.view_your_past_orders_and_status') }}</p>
                            <a href="{{ route('profile.transactions') }}" class="btn-primary px-8 py-3 rounded-full shadow-lg">
                                {{ __('ui.profile.edit.view_transactions') }}
                            </a>
                        </div>
                    </div>

                    <div x-show="activeTab === 'security'" x-transition.opacity style="display: none;" class="space-y-6">
                        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-soft border border-blush-50">
                            <h2 class="text-xl font-serif font-bold text-charcoal mb-6">{{ __('ui.profile.edit.update_password') }}</h2>
                            @include('profile.partials.update-password-form')
                        </div>

                        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-soft border border-red-100">
                            <h2 class="text-xl font-serif font-bold text-red-600 mb-2">{{ __('ui.profile.edit.danger_zone') }}</h2>
                            <p class="text-sm text-gray-500 mb-6">{{ __('ui.profile.edit.once_you_delete_your_account_there_is_no_going_back_please_b') }}</p>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                </main>
            </div>
        </div>
    </div>
</x-app-layout>