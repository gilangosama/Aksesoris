<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-green-50 to-white pt-24 pb-16">
        <div class="container-centered px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto text-center">
            
            <!-- Success Icon -->
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-charcoal mb-4">{{ __('ui.checkout.success.payment_successful') }}</h1>
            <p class="text-lg text-gray-600 mb-8">{{ __('ui.checkout.success.thank_you_for_your_order_we_ll_start_preparing_it_right_away') }}</p>

            <!-- Order Details -->
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-soft border border-gray-100 mb-8 text-left">
                <h2 class="font-serif font-bold text-xl text-charcoal mb-6">{{ __('ui.checkout.success.order_details') }}</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                        <span class="text-gray-600">{{ __('ui.checkout.success.order_number') }}</span>
                        <span class="font-bold text-charcoal font-mono">{{ $order->order_number }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                        <span class="text-gray-600">{{ __('ui.checkout.success.total_amount') }}</span>
                        <span class="font-bold text-lg text-charcoal">{{ __('ui.checkout.success.rp') }} {{ number_format($order->total_price ?? $order->amount, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                        <span class="text-gray-600">{{ __('ui.checkout.success.status') }}</span>
                        <span class="inline-block px-4 py-1 bg-green-100 text-green-700 font-semibold text-sm rounded-full">{{ __('ui.checkout.success.completed') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">{{ __('ui.checkout.success.delivery_address') }}</span>
                        <span class="text-right text-sm text-charcoal max-w-xs">{{ $order->addressRecord->address ?? $order->address }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-soft border border-gray-100 mb-8">
                <h2 class="font-serif font-bold text-xl text-charcoal mb-6 text-left">{{ __('ui.checkout.success.items_ordered') }}</h2>
                
                <div class="space-y-4 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($order->items as $item)
                        <div class="flex justify-between items-center pb-4 border-b border-gray-100 last:border-b-0">
                            <div class="text-left">
                                <p class="font-semibold text-charcoal">{{ $item->name }}</p>
                                <p class="text-sm text-gray-500">{{ $item->quantity }} x {{ __('ui.checkout.success.rp') }} {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="font-bold text-charcoal">{{ __('ui.checkout.success.rp') }} {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">{{ __('ui.checkout.success.no_items_in_order') }}</p>
                    @endforelse
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 md:p-8 mb-8">
                <h3 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('ui.checkout.success.what_happens_next') }}
                </h3>
                <ul class="text-left text-blue-800 space-y-2 text-sm">
                    <li class="flex items-start gap-2">
                        <span class="inline-block w-5 h-5 bg-blue-500 text-white rounded-full text-xs flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                        <span>{{ __('ui.checkout.success.we_ll_confirm_your_order_within_24_hours') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="inline-block w-5 h-5 bg-blue-500 text-white rounded-full text-xs flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                        <span>{{ __('ui.checkout.success.your_item_will_be_carefully_prepared_packed') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="inline-block w-5 h-5 bg-blue-500 text-white rounded-full text-xs flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                        <span>{{ __('ui.checkout.success.tracking_information_will_be_sent_to_your_email') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="inline-block w-5 h-5 bg-blue-500 text-white rounded-full text-xs flex items-center justify-center flex-shrink-0 mt-0.5">4</span>
                        <span>{{ __('ui.checkout.success.expected_delivery_3_5_business_days') }}</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" class="btn-primary py-3 px-6 text-center">
                    {{ __('ui.checkout.success.continue_shopping') }}
                </a>
                <a href="{{ route('profile.transactions') }}" class="border-2 border-blush-600 text-blush-600 font-bold py-3 px-6 rounded-xl hover:bg-blush-50 transition-colors">
                    {{ __('ui.checkout.success.view_my_orders') }}
                </a>
            </div>

            <!-- Contact Support -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <p class="text-gray-600 mb-2">{{ __('ui.checkout.success.need_help') }}</p>
                <p class="text-sm text-gray-500">
                    {{ __('ui.checkout.success.email_us_at') }} <a href="mailto:support@aksesoris.com" class="text-blush-600 hover:underline">{{ __('ui.checkout.success.support_aksesoris_com') }}</a>
                    {{ __('ui.checkout.success.or_check_our') }} <a href="#" class="text-blush-600 hover:underline">{{ __('ui.checkout.success.faq') }}</a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
