<x-app-layout>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.midtrans.client_key') }}"></script>

    <div class="min-h-screen bg-gray-50 pt-24 pb-16">
        <div class="container-centered px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10">
                <h1 class="text-3xl md:text-4xl font-serif font-bold text-charcoal">{{ __('ui.profile.transactions.my_orders') }}</h1>
                <p class="text-gray-500 mt-2">{{ __('ui.profile.transactions.track_your_jewelry_orders_and_view_purchase_history') }}</p>
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
                        </div>
                    </div>

                    <nav class="bg-white rounded-3xl shadow-soft border border-blush-50 overflow-hidden">
                        <a href="{{ route('profile.edit') }}" class="w-full text-left px-6 py-4 font-medium text-gray-600 hover:bg-gray-50 border-l-4 border-transparent transition-all flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ __('ui.profile.transactions.profile_information') }}
                        </a>

                        {{-- <a href="{{ route('profile.edit') }}#addresses" class="w-full text-left px-6 py-4 font-medium text-gray-600 hover:bg-gray-50 border-l-4 border-transparent transition-all flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ __('ui.profile.transactions.address_book') }}
                        </a> --}}

                        <a href="{{ route('profile.transactions') }}" class="w-full text-left px-6 py-4 font-medium bg-blush-50 text-blush-600 border-l-4 border-blush-500 transition-all flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            {{ __('ui.profile.transactions.my_transactions') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100">
                            @csrf
                            <button type="submit" class="w-full text-left px-6 py-4 font-medium text-red-500 hover:bg-red-50 transition-all flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                {{ __('ui.profile.transactions.log_out') }}
                            </button>
                        </form>
                    </nav>
                </aside>

                <main class="lg:col-span-8 space-y-6">
                    
                    <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                        <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap {{ !request('status') ? 'bg-charcoal text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-blush-300' }}">{{ __('ui.profile.transactions.all_orders') }}</a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap {{ request('status') == 'pending' ? 'bg-charcoal text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-blush-300' }}">{{ __('ui.profile.transactions.status_pending') }}</a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}" class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap {{ request('status') == 'completed' ? 'bg-charcoal text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-blush-300' }}">{{ __('ui.profile.transactions.status_completed') }}</a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'process']) }}" class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap {{ request('status') == 'process' ? 'bg-charcoal text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-blush-300' }}">{{ __('ui.profile.transactions.status_process') }}</a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'delivery']) }}" class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap {{ request('status') == 'delivery' ? 'bg-charcoal text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-blush-300' }}">{{ __('ui.profile.transactions.status_delivery') }}</a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'success']) }}" class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap {{ request('status') == 'success' ? 'bg-charcoal text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-blush-300' }}">{{ __('ui.profile.transactions.status_success') }}</a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'cancelled']) }}" class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap {{ request('status') == 'cancelled' ? 'bg-charcoal text-white' : 'bg-white text-gray-600 border border-gray-200 hover:border-blush-300' }}">{{ __('ui.profile.transactions.cancelled') }}</a>
                    </div>

                    @if($orders->isEmpty())
                        <div class="bg-white rounded-3xl shadow-soft border border-blush-50 p-12 text-center">
                            <div class="w-20 h-20 bg-blush-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-blush-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <h3 class="text-xl font-serif font-bold text-charcoal mb-2">{{ __('ui.profile.transactions.no_orders_found') }}</h3>
                            <p class="text-gray-500 mb-6">{{ __('ui.profile.transactions.looks_like_you_haven_t_indulged_in_our_collection_yet') }}</p>
                            <a href="{{ route('products.index') }}" class="btn-primary px-8 py-3 rounded-full shadow-lg">{{ __('ui.profile.transactions.start_shopping') }}</a>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($orders as $order)
                                <div class="bg-white rounded-3xl shadow-soft border border-blush-50 overflow-hidden hover:shadow-md transition-shadow duration-300">
                                    
                                    <div class="bg-gray-50/50 p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                        <div class="flex items-center gap-4">
                                            <div class="bg-white p-2 rounded-lg border border-gray-200">
                                                <svg class="w-6 h-6 text-blush-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500 uppercase tracking-wide">{{ __('ui.profile.transactions.order_id') }}</p>
                                                <p class="font-bold text-charcoal font-serif">{{ $order->order_number }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex flex-col sm:items-end">
                                            <div class="flex items-center gap-2 mb-1">
                                                @php
                                                    $statusClasses = [
                                                        'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                                        'completed' => 'bg-green-100 text-green-700 border-green-200',
                                                        'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                        'cancelled' => 'bg-red-50 text-red-600 border-red-100',
                                                        'failed' => 'bg-red-50 text-red-600 border-red-100',
                                                    ];
                                                    $class = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                                                @endphp
                                                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full border {{ $class }}">
                                                    {{ __('ui.profile.transactions.status_' . $order->status) ?? ucfirst($order->status) }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <div class="space-y-4">
                                            @foreach($order->items as $item)
                                                <div class="flex gap-4 items-center">
                                                    <div class="w-16 h-16 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 border border-gray-200">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($item->product->image) }}" class="w-full h-full object-cover">
                                                            <div class="w-full h-full flex items-center justify-center text-gray-300 text-xs">{{ __('ui.profile.transactions.no_img') }}</div>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="flex-1">
                                                        <h4 class="font-semibold text-charcoal text-sm sm:text-base">{{ $item->product_name }}</h4>
                                                        <p class="text-xs text-gray-500">{{ $item->quantity }} {{ __('ui.profile.transactions.x_rp') }} {{ number_format($item->price, 0, ',', '.') }}</p>
                                                    </div>

                                                    <div class="text-right">
                                                        <p class="font-medium text-gray-900 text-sm">{{ __('ui.profile.transactions.rp') }} {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4 border-t border-gray-100">
                                        <div class="text-center sm:text-left">
                                            <span class="text-sm text-gray-500">{{ __('ui.profile.transactions.total_amount') }}</span>
                                            <p class="text-xl font-serif font-bold text-blush-600">{{ __('ui.profile.transactions.rp') }} {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                        </div>

                                        <div class="flex gap-3 w-full sm:w-auto">
                                            @if($order->status === 'pending' && $order->snap_token)
                                                <button onclick="snap.pay('{{ $order->snap_token }}')" class="flex-1 sm:flex-none btn-primary px-6 py-2 rounded-lg text-sm shadow-md hover:shadow-lg">
                                                    {{ __('ui.profile.transactions.pay_now') }}
                                                </button>
                                            @endif

                                            <a href="{{ route('profile.transactions.show', $order) }}" class="flex-1 sm:flex-none px-6 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-white hover:border-blush-300 transition text-center">
                                                {{ __('ui.profile.transactions.view_details') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-8">
                            {{ $orders->links() }}
                        </div>
                    @endif

                </main>
            </div>
        </div>
    </div>
</x-app-layout>