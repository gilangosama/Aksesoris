<x-app-layout>
    <!-- Midtrans Snap Script - MUST load before calling snap.pay() -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <div class="min-h-screen bg-gray-50 pt-24 pb-16" x-data="checkoutHandler()" x-init="init()" x-cloak>
        <div class="container-centered px-4 sm:px-6 lg:px-8">
            
            <nav class="flex mb-8 text-sm text-gray-500">
                <a href="{{ route('cart.index') }}" class="hover:text-blush-500 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    {{ __('ui.cart.checkout.back_to_cart') }}
                </a>
            </nav>

            <h1 class="text-3xl md:text-4xl font-serif font-bold text-charcoal mb-8">{{ __('ui.cart.checkout.secure_checkout') }}</h1>

            <form id="checkout-form" @submit.prevent="processPayment">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                    
                    <div class="lg:col-span-2 space-y-8">
                        
                        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                            <h2 class="font-serif font-bold text-xl text-charcoal mb-6 flex items-center gap-2">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blush-100 text-blush-600 text-sm">1</span>
                                {{ __('ui.cart.checkout.delivery_address') }}
                            </h2>

                            <div class="space-y-4" id="addresses-list">
                                @forelse(auth()->user()->addresses as $address)
                                    <label class="cursor-pointer block group">
                                        <input 
                                            type="radio" 
                                            name="address_id" 
                                            value="{{ $address->id }}"
                                            class="sr-only peer"
                                            data-address-id="{{ $address->id }}"
                                            data-city="{{ strtolower(trim($address->city)) }}"
                                        >
                                        <div class="js-address-card relative p-5 rounded-xl border-2 transition-all duration-200 border-gray-200 group-hover:border-blush-200" data-address-id="{{ $address->id }}">
                                            <div class="flex items-start justify-between">
                                                <div class="flex items-start gap-3 flex-1">
                                                    <div class="mt-1 flex-shrink-0">
                                                        <div class="js-radio-indicator w-5 h-5 rounded-full border-2 flex items-center justify-center border-gray-300">
                                                            <div class="js-radio-dot w-2.5 h-2.5 rounded-full bg-blush-500 opacity-0 transition-opacity"></div>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="font-semibold text-charcoal">{{ $address->recipient_name ?? auth()->user()->name }}</p>
                                                        <p class="text-gray-600 text-sm mt-1">{{ $address->street }}</p>
                                                        <p class="text-gray-500 text-sm mt-1">{{ $address->city }}, {{ $address->province }}, {{ $address->postal_code }}</p>
                                                        <p class="text-gray-500 text-sm mt-1">{{ __('ui.cart.checkout.phone') }} {{ $address->phone }}</p>
                                                    </div>
                                                </div>
                                                @if($address->is_default)
                                                    <span class="bg-gray-100 text-gray-600 text-[10px] uppercase font-bold px-2 py-1 rounded-full tracking-wider flex-shrink-0 ml-3">{{ __('ui.cart.checkout.default') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-gray-500 text-sm italic">{{ __('ui.cart.checkout.you_haven_t_saved_any_addresses_yet') }}</p>
                                @endforelse

                                <button 
                                    type="button" 
                                    id="add-address-btn"
                                    class="flex items-center gap-2 text-blush-600 font-semibold text-sm hover:underline mt-4"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    {{ __('ui.cart.checkout.add_new_address') }}
                                </button>
                            </div>
                        </div>

                        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                            <h2 class="font-serif font-bold text-xl text-charcoal mb-4 flex items-center gap-2">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blush-100 text-blush-600 text-sm">2</span>
                                {{ __('ui.cart.checkout.shipping_method') }}
                            </h2>

                            <div class="space-y-4">
                                <label class="block border rounded-3xl p-4 cursor-pointer transition hover:border-blush-200" :class="deliveryMethod === 'delivery' ? 'border-blush-300 bg-blush-50/50' : 'border-gray-200 bg-white'">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="delivery_method" value="delivery" x-model="deliveryMethod" class="h-4 w-4 text-blush-600 border-gray-300 focus:ring-blush-500" checked>
                                        <div>
                                            <p class="font-semibold text-charcoal">{{ __('ui.cart.checkout.delivery') }}</p>
                                            <p class="text-xs text-gray-500">{{ __('ui.cart.checkout.secure_insured_shipping') }}</p>
                                        </div>
                                    </div>
                                </label>

                                <label class="block border rounded-3xl p-4 cursor-pointer transition hover:border-blush-200" :class="deliveryMethod === 'pickup' ? 'border-blush-300 bg-blush-50/50' : 'border-gray-200 bg-white'">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="delivery_method" value="pickup" x-model="deliveryMethod" class="h-4 w-4 text-blush-600 border-gray-300 focus:ring-blush-500">
                                        <div>
                                            <p class="font-semibold text-charcoal">{{ __('ui.cart.checkout.pickup') }}</p>
                                            <p class="text-xs text-gray-500">{{ __('ui.cart.checkout.pickup_local_store') }}</p>
                                        </div>
                                    </div>
                                </label>

                                <p id="pickup_help_text" class="text-xs text-gray-500">
                                    <span x-text="pickupHelpText"></span>
                                </p>

                                <div x-show="deliveryMethod === 'pickup'" x-transition class="space-y-3">
                                    <label for="pickup_location_id" class="block text-sm font-semibold text-charcoal">{{ __('ui.cart.checkout.pickup_location') }}</label>
                                    <select name="pickup_location_id" id="pickup_location_id" x-model="pickupLocationId" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blush-500">
                                        <option value="">{{ __('ui.cart.checkout.select_a_pickup_location') }}</option>
                                        @foreach($allPickupLocations as $location)
                                            <option value="{{ $location->id }}" data-city="{{ strtolower(trim($location->city)) }}">{{ $location->name }} - {{ $location->address }}, {{ $location->city }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500" x-text="pickupHelpText"></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                            <div class="flex items-start gap-3">
                                <div class="flex items-center h-5">
                                    <input id="is_gift" name="is_gift" type="checkbox" x-model="isGift" class="focus:ring-blush-500 h-5 w-5 text-blush-600 border-gray-300 rounded cursor-pointer">
                                </div>
                                <div class="flex-1">
                                    <label for="is_gift" class="font-serif font-bold text-charcoal cursor-pointer select-none">
                                        {{ __('ui.cart.checkout.is_this_a_gift') }}
                                    </label>
                                    <p class="text-gray-500 text-sm">{{ __('ui.cart.checkout.we_ll_remove_the_price_tag_and_include_a_premium_card') }}</p>
                                </div>
                            </div>

                            <div x-show="isGift" x-transition class="mt-4 pl-8">
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('ui.cart.checkout.gift_message_optional') }}</label>
                                <textarea name="gift_message" rows="3" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blush-500 focus:ring focus:ring-blush-200 transition" placeholder="{{ __('ui.cart.checkout.write_a_heartfelt_message') }}"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="sticky top-28 bg-white p-6 rounded-3xl shadow-soft border border-blush-50">
                            <h2 class="font-serif font-bold text-xl text-charcoal mb-6">{{ __('ui.cart.checkout.order_summary') }}</h2>

                            <div class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($cart as $item)
                                    <div class="flex gap-3">
                                        <img src="{{ asset('storage/' . $item['image']) }}" class="w-16 h-16 object-cover rounded-lg border border-gray-100">
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-charcoal line-clamp-1">{{ $item['name'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $item['quantity'] }} {{ __('ui.cart.checkout.x_rp') }} {{ number_format($item['price'], 0, ',', '.') }}</p>
                                        </div>
                                        <p class="text-sm font-medium text-charcoal">{{ __('ui.cart.checkout.rp') }} {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-dashed border-gray-200 my-4"></div>

                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>{{ __('ui.cart.checkout.subtotal') }}</span>
                                    <span>{{ __('ui.cart.checkout.rp') }} {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>{{ __('ui.cart.checkout.gift_wrapping') }}</span>
                                    <span class="text-green-600 font-semibold">{{ __('ui.cart.checkout.free') }}</span>
                                </div>
                                <div x-show="isGift" class="flex justify-between text-gray-600">
                                    <span>{{ __('ui.cart.checkout.gift_wrapping') }}</span>
                                    <span class="text-green-600 font-semibold">{{ __('ui.cart.checkout.free') }}</span>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 my-4 pt-4">
                                <div class="flex justify-between items-end">
                                    <span class="font-bold text-gray-900">{{ __('ui.cart.checkout.total') }}</span>
                                    <span class="font-serif font-bold text-2xl text-charcoal">{{ __('ui.cart.checkout.rp') }} {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button 
                                type="submit" 
                                :disabled="loading || !selectedAddressId"
                                class="w-full btn-primary py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                            >
                                <svg x-show="loading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span x-text="loading ? processingText : payNowText"></span>
                            </button>

                            <div class="mt-6 flex flex-col items-center gap-2 text-center">
                                <div class="flex gap-2 opacity-50 grayscale">
                                    <span class="text-[10px] font-bold border border-gray-300 px-1 rounded">{{ __('ui.cart.checkout.visa') }}</span>
                                    <span class="text-[10px] font-bold border border-gray-300 px-1 rounded">{{ __('ui.cart.checkout.mc') }}</span>
                                    <span class="text-[10px] font-bold border border-gray-300 px-1 rounded">{{ __('ui.cart.checkout.qris') }}</span>
                                </div>
                                <p class="text-xs text-gray-400 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    {{ __('ui.cart.checkout.encrypted_secure_payment_via_midtrans') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div 
            x-show="openAddressModal" 
            x-transition
            class="fixed inset-0 z-50 overflow-y-auto" 
            aria-labelledby="modal-title" 
            role="dialog" 
            aria-modal="true"
        >
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openAddressModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openAddressModal = false"></div>

                <div x-show="openAddressModal" x-transition class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">{{ __('ui.cart.checkout.add_new_address') }}</h3>
                        <form id="new-address-form">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">{{ __('ui.cart.checkout.recipient_name') }}</label>
                                    <input type="text" x-model="newAddress.recipient_name" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blush-500 focus:ring focus:ring-blush-200 px-3 py-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">{{ __('ui.cart.checkout.street_address') }}</label>
                                    <input type="text" x-model="newAddress.street" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blush-500 focus:ring focus:ring-blush-200 px-3 py-2">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">{{ __('ui.cart.checkout.city') }}</label>
                                        <input type="text" x-model="newAddress.city" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blush-500 focus:ring focus:ring-blush-200 px-3 py-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">{{ __('ui.cart.checkout.province') }}</label>
                                        <input type="text" x-model="newAddress.province" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blush-500 focus:ring focus:ring-blush-200 px-3 py-2">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">{{ __('ui.cart.checkout.postal_code') }}</label>
                                        <input type="text" x-model="newAddress.postal_code" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blush-500 focus:ring focus:ring-blush-200 px-3 py-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">{{ __('ui.cart.checkout.phone_2') }}</label>
                                        <input type="tel" x-model="newAddress.phone" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blush-500 focus:ring focus:ring-blush-200 px-3 py-2">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" @click="saveAddress" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blush-600 text-base font-medium text-white hover:bg-blush-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            {{ __('ui.cart.checkout.save_address') }}
                        </button>
                        <button type="button" @click="openAddressModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ __('ui.cart.checkout.cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkoutHandler() {
            return {
                selectedAddressId: null,
                loading: false,
                isGift: false,
                deliveryMethod: 'delivery',
                pickupLocationId: null,
                pickupAvailable: true,
                pickupHelpText: '{{ __('ui.cart.checkout.pickup_available_for_your_city') }}',
                openAddressModal: false,
                processingText: '{{ __('ui.cart.checkout.processing') }}',
                payNowText: '{{ __('ui.cart.checkout.pay_now') }}',
                newAddress: {
                    recipient_name: '{{ auth()->user()->name }}',
                    street: '',
                    city: '',
                    province: '',
                    postal_code: '',
                    phone: ''
                },
                init() {
                    // Set default address ID on component init
                    const defaultAddress = {{ auth()->user()->addresses->firstWhere('is_default', true)?->id ?? 'null' }};
                    if (defaultAddress !== null) {
                        this.selectedAddressId = defaultAddress;
                    }
                    
                    // Setup radio button listeners and styling
                    const self = this;
                    const radioButtons = document.querySelectorAll('input[name="address_id"]');
                    const addAddressBtn = document.getElementById('add-address-btn');
                    
                    // Helper function to update visual styles
                    function updateAddressStyles() {
                        const checkedRadio = document.querySelector('input[name="address_id"]:checked');
                        
                        // Reset all cards
                        document.querySelectorAll('.js-address-card').forEach(card => {
                            card.classList.remove('border-blush-500', 'bg-blush-50/30');
                            const indicator = card.querySelector('.js-radio-indicator');
                            const dot = card.querySelector('.js-radio-dot');
                            if (indicator) indicator.classList.remove('border-blush-500');
                            if (dot) dot.classList.add('opacity-0');
                        });
                        
                        // Style checked card
                        if (checkedRadio) {
                            const card = checkedRadio.closest('label').querySelector('.js-address-card');
                            if (card) {
                                card.classList.add('border-blush-500', 'bg-blush-50/30');
                                const indicator = card.querySelector('.js-radio-indicator');
                                const dot = card.querySelector('.js-radio-dot');
                                if (indicator) indicator.classList.add('border-blush-500');
                                if (dot) dot.classList.remove('opacity-0');
                            }
                        }
                    }
                    
                    // Setup event listeners on radio buttons
                    radioButtons.forEach(radio => {
                        radio.addEventListener('change', (e) => {
                            self.selectedAddressId = parseInt(e.target.value);
                            updateAddressStyles();
                            self.updatePickupAvailability();
                            console.log('✓ Address selected:', self.selectedAddressId);
                        });
                    });
                    
                    // Set initial checked state and styles
                    const checkedRadio = document.querySelector('input[name="address_id"]:checked');
                    if (checkedRadio) {
                        this.selectedAddressId = parseInt(checkedRadio.value);
                    } else if (radioButtons.length > 0) {
                        radioButtons[0].checked = true;
                        this.selectedAddressId = parseInt(radioButtons[0].value);
                    }
                    updateAddressStyles();
                    this.updatePickupAvailability();
                    
                    // Setup add address button  
                    if (addAddressBtn) {
                        addAddressBtn.addEventListener('click', (e) => {
                            e.preventDefault();
                            console.log('✓ Opening address modal');
                            this.openAddressModal = true;
                        });
                    } else {
                        console.warn('⚠️ Add address button not found');
                    }
                },

                normalizeCity(city) {
                    if (!city) {
                        return '';
                    }

                    let normalized = city.toLowerCase().trim();
                    normalized = normalized.replace(/\b(kota|kabupaten|kab|provinsi|prov|jawa barat|jawa tengah|jawa timur|sumatera utara|daerah istimewa yogyakarta)\b/g, '');
                    normalized = normalized.replace(/[^\p{L}\p{N}]+/gu, ' ');
                    return normalized.trim();
                },

                updatePickupAvailability() {
                    const pickupSelect = document.getElementById('pickup_location_id');
                    let availableCount = 0;

                    if (pickupSelect) {
                        Array.from(pickupSelect.options).forEach(option => {
                            option.hidden = false;
                            if (option.value) {
                                availableCount++;
                            }
                        });
                    }

                    this.pickupAvailable = availableCount > 0;

                    if (this.pickupAvailable) {
                        this.pickupHelpText = '{{ __('ui.cart.checkout.pickup_available_for_your_city') }}';
                    } else {
                        this.pickupHelpText = '{{ __('ui.cart.checkout.pickup_unavailable_for_your_city') }}';
                        this.pickupLocationId = null;
                    }
                },

                // 1. Logic Save New Address via AJAX
                async saveAddress() {
                    // Simple Validation
                    if(!this.newAddress.recipient_name || !this.newAddress.street || !this.newAddress.city || !this.newAddress.province || !this.newAddress.postal_code || !this.newAddress.phone) {
                        alert('{{ __('ui.cart.checkout.please_fill_in_all_required_fields') }}');
                        return;
                    }

                    try {
                        const response = await fetch('{{ route("addresses.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(this.newAddress)
                        });
                        
                        const data = await response.json();
                        
                        if(data.success) {
                            // Reload page to reflect new address (Simpler than appending DOM manually)
                            alert('{{ __('ui.cart.checkout.address_saved_successfully') }}');
                            window.location.reload(); 
                        } else {
                            const errors = data.errors ? Object.entries(data.errors).map(([key, msgs]) => `${key}: ${msgs.join(', ')}`).join('\n') : data.message;
                            alert('{{ __('ui.cart.checkout.failed_to_save_address') }}\n' + (errors || 'Unknown error'));
                        }
                    } catch(e) {
                        console.error('Error:', e);
                        alert('{{ __('ui.cart.checkout.error_saving_address') }}\n' + e.message);
                    }
                },

                // 2. Logic Process Payment (Create Order -> Get Snap Token -> Show Popup)
                async processPayment() {
                    if (!this.selectedAddressId) {
                        alert('{{ __('ui.cart.checkout.please_select_a_delivery_address') }}');
                        return;
                    }

                    this.loading = true;
                    const self = this; // Save 'this' context

                    // Ambil data form
                    const form = document.getElementById('checkout-form');
                    const formData = new FormData(form);

                    try {
                        // A. Create Order & Get Snap Token from Backend
                        const response = await fetch('{{ route("checkout.process") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (!data.success) {
                            throw new Error(data.message);
                        }

                        // B. Check if snap is loaded
                        if (!window.snap) {
                            throw new Error('{{ __('ui.cart.checkout.midtrans_snap_not_loaded') }}');
                        }

                        // C. Open Midtrans Snap Popup
                        window.snap.pay(data.snap_token, {
                            onSuccess: async function(result){
                                // Sync order status with Midtrans before redirecting
                                try {
                                    const syncResponse = await fetch('{{ route("payment.sync-status") }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                        },
                                        body: JSON.stringify({
                                            order_id: data.order_id,
                                        })
                                    });
                                    
                                    const syncData = await syncResponse.json();
                                    console.log('Order status synced:', syncData.order_status);
                                } catch (err) {
                                    console.error('Sync error:', err);
                                }
                                
                                // Redirect to Success Page
                                window.location.href = "{{ route('checkout.success') }}?order_id=" + data.order_id;
                            },
                            onPending: function(result){
                                window.location.href = "{{ route('checkout.pending') }}";
                            },
                            onError: function(result){
                                alert("{{ __('ui.cart.checkout.payment_failed') }}");
                                console.error(result);
                                self.loading = false;
                            },
                            onClose: function(){
                                alert('{{ __('ui.cart.checkout.closed_popup_without_finishing_payment') }}');
                                self.loading = false;
                            }
                        });

                    } catch (error) {
                        console.error('Error:', error);
                        alert(error.message || '{{ __('ui.cart.checkout.something_went_wrong_processing_order') }}');
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</x-app-layout>