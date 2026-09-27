<x-app-layout>
    <div class="min-h-screen bg-gray-50 pt-24 pb-16">
        <div class="container-centered px-4 sm:px-6 lg:px-8">
            <div class="mb-10">
                <h1 class="text-3xl md:text-4xl font-serif font-bold text-charcoal">{{ __('ui.profile.transactions.order_details') }}</h1>
                <p class="text-gray-500 mt-2">{{ __('ui.profile.transactions.view_your_order_information_and_shipping_details') }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                <aside class="lg:col-span-4 space-y-6">
                    <div class="bg-white p-6 rounded-3xl shadow-soft border border-blush-50">
                        <h2 class="text-sm uppercase font-semibold tracking-wider text-gray-500 mb-4">{{ __('ui.profile.transactions.order_summary') }}</h2>
                        <div class="space-y-4 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span>{{ __('ui.profile.transactions.order_id') }}</span>
                                <span class="font-semibold text-charcoal">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>{{ __('ui.profile.transactions.status') }}</span>
                                <span class="font-semibold text-charcoal">{{ __('ui.profile.transactions.status_' . $order->status) ?? ucfirst($order->status) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>{{ __('ui.profile.transactions.payment_method') }}</span>
                                <span class="font-semibold text-charcoal">{{ $order->payment_method ? ucwords(str_replace('_', ' ', $order->payment_method)) : '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>{{ __('ui.profile.transactions.total_amount') }}</span>
                                <span class="font-semibold text-charcoal">{{ __('ui.profile.transactions.rp') }} {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                            @if($order->tracking_number)
                                <div class="flex justify-between">
                                    <span>{{ __('ui.profile.transactions.tracking_number') }}</span>
                                    <span class="font-semibold text-charcoal">{{ $order->tracking_number }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl shadow-soft border border-blush-50">
                        <h2 class="text-sm uppercase font-semibold tracking-wider text-gray-500 mb-4">{{ __('ui.profile.transactions.shipping_information') }}</h2>
                        <div class="space-y-4 text-sm text-gray-700">
                            <div>
                                <span class="block text-gray-500">{{ __('ui.profile.transactions.delivery_method') }}</span>
                                <p class="font-semibold text-charcoal">{{ __('ui.profile.transactions.' . ($order->delivery_method === 'pickup' ? 'pickup' : 'delivery')) }}</p>
                            </div>
                            <div>
                                <span class="block text-gray-500">{{ __('ui.profile.transactions.address') }}</span>
                                @if($order->addressRecord)
                                    <p class="text-charcoal">
                                        {{ $order->addressRecord->recipient_name }}<br>
                                        {{ $order->addressRecord->street }}<br>
                                        {{ $order->addressRecord->city }}, {{ $order->addressRecord->province }} {{ $order->addressRecord->postal_code }}
                                    </p>
                                @else
                                    <p class="text-charcoal">{{ $order->address ?? '-' }}</p>
                                @endif
                            </div>
                            @if($order->pickupLocation)
                                <div>
                                    <span class="block text-gray-500">{{ __('ui.profile.transactions.pickup_location') }}</span>
                                    <p class="text-charcoal">{{ $order->pickupLocation->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->pickupLocation->address }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </aside>

                <main class="lg:col-span-8 space-y-6">
                    <div class="bg-white rounded-3xl shadow-soft border border-blush-50 p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                            <div>
                                <h2 class="text-xl font-semibold text-charcoal">{{ __('ui.profile.transactions.items_ordered') }}</h2>
                                <p class="text-sm text-gray-500">{{ __('ui.profile.transactions.order_items_summary') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @forelse($order->items as $item)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 border border-gray-100 rounded-3xl">
                                    <div class="min-w-0">
                                        <p class="font-semibold text-charcoal">{{ $item->product_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $item->quantity }} {{ __('ui.profile.transactions.x_rp') }} {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-charcoal">{{ __('ui.profile.transactions.rp') }} {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 text-gray-500">
                                    {{ __('ui.profile.transactions.no_items_in_order') }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    @if($order->tracking_number)
                        <div class="bg-white rounded-3xl shadow-soft border border-blush-50 p-6">
                            <h3 class="text-lg font-semibold text-charcoal mb-4">{{ __('ui.profile.transactions.tracking_number') }}</h3>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                <p id="trackingNumberValue" class="text-sm text-gray-500 break-words">{{ $order->tracking_number }}</p>
                                <button id="copyTrackingNumberButton" type="button" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-charcoal hover:bg-gray-100 transition">
                                    {{ __('ui.profile.transactions.copy_tracking_number') }}
                                </button>
                            </div>
                        </div>
                    @endif

                    @if($order->status === 'success')
                        <div class="bg-white rounded-3xl shadow-soft border border-blush-50 p-6">
                            <h3 class="text-lg font-semibold text-charcoal mb-4">{{ __('ui.profile.transactions.review_your_order') }}</h3>

                            @if(session('success'))
                                <div class="mb-4 rounded-2xl bg-green-50 border border-green-200 p-4 text-sm text-green-700">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="mb-4 rounded-2xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">{{ session('error') }}</div>
                            @endif
                            @if($errors->any())
                                <div class="mb-4 rounded-2xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            @if($order->rating)
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="text-xl {{ $i <= $order->rating->rating ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                                        @endfor
                                    </div>
                                    @if($order->rating->review)
                                        <p class="text-sm text-gray-600">{{ $order->rating->review }}</p>
                                    @endif
                                </div>
                            @else
                                <form action="{{ route('profile.transactions.rating.store', $order) }}" method="POST" class="space-y-6">
                                    @csrf
                                    <div class="rounded-3xl border border-gray-200 bg-slate-50 p-5">
                                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                            <div>
                                                <h4 class="text-base font-semibold text-charcoal">{{ __('ui.profile.transactions.rating') }}</h4>
                                                <p class="text-sm text-gray-500">{{ __('ui.profile.transactions.select_rating') }}</p>
                                            </div>
                                            <div id="ratingStars" class="flex items-center gap-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <button type="button" data-rating="{{ $i }}" class="star-button text-3xl text-gray-300 transition hover:text-yellow-400 focus:outline-none">★</button>
                                                @endfor
                                            </div>
                                        </div>
                                        <input type="hidden" id="ratingInput" name="rating" value="{{ old('rating', '') }}">
                                        @error('rating')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="review" class="block text-sm font-medium text-gray-700">{{ __('ui.profile.transactions.review_optional') }}</label>
                                        <textarea id="review" name="review" rows="4" class="mt-2 block w-full rounded-3xl border border-gray-200 bg-white py-4 px-4 text-sm shadow-sm focus:border-blush-500 focus:ring-blush-500" placeholder="{{ __('ui.profile.transactions.leave_a_comment') }}">{{ old('review') }}</textarea>
                                    </div>

                                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-blush-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blush-200/40 hover:bg-blush-700 transition">
                                        {{ __('ui.profile.transactions.submit_rating') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('profile.transactions') }}" class="flex-1 inline-flex justify-center items-center px-6 py-3 rounded-full border border-gray-300 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                            {{ __('ui.profile.transactions.back_to_orders') }}
                        </a>
                        <a href="{{ route('products.index') }}" class="flex-1 inline-flex justify-center items-center px-6 py-3 rounded-full bg-blush-600 text-white text-sm font-semibold hover:bg-blush-700 transition">
                            {{ __('ui.profile.transactions.continue_shopping') }}
                        </a>
                    </div>
                </main>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const copyButton = document.getElementById('copyTrackingNumberButton');
                const trackingValueEl = document.getElementById('trackingNumberValue');

                if (copyButton && trackingValueEl && navigator.clipboard) {
                    copyButton.addEventListener('click', async function () {
                        const text = trackingValueEl.textContent.trim();
                        if (!text) {
                            return;
                        }

                        try {
                            await navigator.clipboard.writeText(text);
                            const originalText = copyButton.textContent;
                            copyButton.textContent = '{{ __('ui.profile.transactions.copied') }}';
                            copyButton.disabled = true;
                            setTimeout(() => {
                                copyButton.textContent = originalText;
                                copyButton.disabled = false;
                            }, 2000);
                        } catch (error) {
                            console.error('Clipboard copy failed:', error);
                        }
                    });
                }

                const ratingStars = document.querySelectorAll('#ratingStars .star-button');
                const ratingInput = document.getElementById('ratingInput');
                const initialRating = Number('{{ old('rating', 0) }}');

                function setRating(value) {
                    ratingInput.value = value;
                    ratingStars.forEach((button) => {
                        const starValue = Number(button.dataset.rating);
                        button.classList.toggle('text-yellow-500', starValue <= value);
                        button.classList.toggle('text-gray-300', starValue > value);
                    });
                }

                if (ratingStars.length && ratingInput) {
                    ratingStars.forEach((button) => {
                        button.addEventListener('click', function () {
                            setRating(Number(this.dataset.rating));
                        });
                    });

                    if (initialRating > 0) {
                        setRating(initialRating);
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
