<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-yellow-50 to-white pt-24 pb-16">
        <div class="container-centered px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto text-center">
            
            <!-- Pending Icon -->
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-yellow-100">
                    <svg class="w-10 h-10 text-yellow-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-charcoal mb-4">{{ __('ui.checkout.pending.payment_pending') }}</h1>
            <p class="text-lg text-gray-600 mb-8">{{ __('ui.checkout.pending.we_re_waiting_to_hear_back_from_the_payment_system_please_do') }}</p>

            <!-- Status Box -->
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-soft border border-gray-100 mb-8">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                    <span class="font-semibold text-yellow-700">{{ __('ui.checkout.pending.waiting_for_confirmation') }}</span>
                </div>
                <p class="text-gray-600 text-sm">{{ __('ui.checkout.pending.this_typically_takes_a_few_moments_we_ll_automatically_redir') }}</p>
            </div>

            <!-- Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 md:p-8 mb-8">
                <h3 class="font-bold text-blue-900 mb-4">{{ __('ui.checkout.pending.important') }}</h3>
                <ul class="text-left text-blue-800 space-y-2 text-sm">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span>{{ __('ui.checkout.pending.do_not_close_this_page_or_refresh_your_browser') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span>{{ __('ui.checkout.pending.your_order_is_secure_and_has_been_created_in_our_system') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span>{{ __('ui.checkout.pending.if_payment_is_confirmed_you_ll_see_a_success_page') }}</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="history.back()" class="btn-primary py-3 px-6 text-center">
                    {{ __('ui.checkout.pending.go_back') }}
                </button>
                <a href="{{ route('cart.index') }}" class="border-2 border-blush-600 text-blush-600 font-bold py-3 px-6 rounded-xl hover:bg-blush-50 transition-colors">
                    {{ __('ui.checkout.pending.back_to_cart') }}
                </a>
            </div>

            <!-- Contact Support -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-gray-600 mb-2">{{ __('ui.checkout.pending.issues_with_payment') }}</p>
                <p class="text-sm text-gray-500">
                    {{ __('ui.checkout.pending.contact_our_support_team_at') }} <a href="mailto:support@aksesoris.com" class="text-blush-600 hover:underline">{{ __('ui.checkout.pending.support_aksesoris_com') }}</a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
