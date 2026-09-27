<x-app-layout>
<div class="min-h-screen bg-gradient-to-b from-white to-blush-50 pt-32 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-charcoal mb-2">{{ __('ui.create_custom.checkout.review_pay_for_your_custom_design') }}</h1>
            <p class="text-gray-600">{{ __('ui.create_custom.checkout.complete_your_order_and_preview_your_design_one_more_time_be') }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Design Preview (Modal-style) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg border-2 border-blush-200 p-8 sticky top-32">
                    <h2 class="text-xl font-bold text-charcoal mb-6">{{ __('ui.create_custom.checkout.your_custom_design') }}</h2>

                    <!-- Visual Preview Area -->
                    <div id="design-preview" class="relative mx-auto mb-8" style="width: 500px; max-width: 100%; aspect-ratio: 1; border: 2px solid #e5b5ca; border-radius: 8px; background: linear-gradient(135deg, #fff5f8 0%, #fce4ec 100%); overflow: hidden;">
                        <!-- Jewelry Image/Icon (Center) -->
                        <div class="absolute inset-0 flex items-center justify-center" style="z-index: 1;">
                            @php
                                $jewelry = \App\Models\CustomizableJewelry::where('type', $inquiry->type)->first();
                            @endphp
                            @if($inquiry->chainStyle && $inquiry->chainStyle->image)
                                @php
                                    $chainImageUrl = $inquiry->chainStyle->image;
                                    if (!filter_var($chainImageUrl, FILTER_VALIDATE_URL)) {
                                        $chainImageUrl = asset('storage/' . $chainImageUrl);
                                    }
                                @endphp
                                <img src="{{ $chainImageUrl }}" 
                                     alt="{{ $inquiry->chainStyle->name }}" 
                                     class="max-w-sm max-h-96 object-contain"
                                     style="filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1)); z-index: 1;"
                                     crossorigin="anonymous">
                            @elseif($jewelry && $jewelry->image)
                                <img src="{{ asset('storage/' . $jewelry->image) }}" 
                                     alt="{{ $jewelry->label }}" 
                                     class="max-w-sm max-h-full object-contain"
                                     crossorigin="anonymous">
                            @else
                                <div class="text-center">
                                    <div class="text-6xl mb-4">
                                        @switch($inquiry->type)
                                            @case('necklace')
                                                📿
                                            @break
                                            @case('bracelet')
                                                💍
                                            @break
                                            @case('hand_chain')
                                                🔗
                                            @break
                                            @case('earrings')
                                                ✨
                                            @break
                                            @case('keychain')
                                                🔑
                                            @break
                                            @default
                                                💎
                                        @endswitch
                                    </div>
                                    <p class="text-gray-600 text-sm">{{ $jewelry->label ?? 'Jewelry' }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Grid Reference Lines (hidden in capture) -->
                        <div class="design-preview-hide absolute inset-0 pointer-events-none" style="background-image: linear-gradient(rgba(229, 181, 202, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(229, 181, 202, 0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>

                        <!-- Positioned Charms -->
                        @forelse($inquiry->charmDesignItems as $item)
                            @php
                                $charm = $item->charm;
                                $posX = $item->charm_position_x ?? 250;
                                $posY = $item->charm_position_y ?? 250;

                                // convert legacy 0-500 pixel-based value into 0-100 percentage scale
                                if ($posX > 100) {
                                    $posX = min(100, max(0, round($posX / 5)));
                                }
                                if ($posY > 100) {
                                    $posY = min(100, max(0, round($posY / 5)));
                                }
                            @endphp
                            <div class="design-charm-item absolute w-20 h-20 flex items-center justify-center rounded-full overflow-hidden" 
                                 data-original-x="{{ $posX }}" data-original-y="{{ $posY }}"
                                 style="left: {{ $posX }}%; top: {{ $posY }}%; transform: translate(-50%, -50%); z-index: 10;">
                                @if($charm && $charm->image && trim($charm->image) !== '')
                                    @php
                                        $charmImageUrl = $charm->image;
                                        if (!filter_var($charmImageUrl, FILTER_VALIDATE_URL)) {
                                            $charmImageUrl = asset('storage/' . $charmImageUrl);
                                        }
                                    @endphp
                                    <img src="{{ $charmImageUrl }}" 
                                         alt="{{ $charm->name }}" 
                                         class="w-full h-full object-contain p-1"
                                         crossorigin="anonymous">
                                @else
                                    <span class="text-2xl">
                                        @switch(strtolower($charm->name ?? ''))
                                            @case('diamond heart')
                                            @case('diamond clasp')
                                                💎
                                            @break
                                            @case('pearl accent')
                                            @case('pearl drop')
                                            @case('pearl end')
                                                🔱
                                            @break
                                            @case('crystal bead')
                                            @case('crystal cluster')
                                                ✨
                                            @break
                                            @case('gemstone drop')
                                            @case('gemstone charm')
                                            @case('gemstone center')
                                                💜
                                            @break
                                            @case('gold tag')
                                            @case('ring connector')
                                                🏆
                                            @break
                                            @default
                                                ⭐
                                        @endswitch
                                    </span>
                                @endif
                            </div>
                        @empty
                        @endforelse
                    </div>

                    <!-- Design Summary -->
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-center pb-4 border-b border-blush-100">
                            <span class="text-gray-600">{{ __('ui.create_custom.checkout.jewelry_type') }}</span>
                            <span class="font-semibold text-charcoal capitalize">{{ str_replace('_', ' ', $inquiry->type) }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-blush-100">
                            <span class="text-gray-600">{{ __('ui.create_custom.checkout.finish') }}</span>
                            <span class="font-semibold text-charcoal capitalize">{{ $inquiry->finish }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-blush-100">
                            <span class="text-gray-600">{{ __('ui.create_custom.checkout.chain_style') }}</span>
                            <span class="font-semibold text-charcoal">{{ $inquiry->chainStyle->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-blush-100">
                            <span class="text-gray-600">{{ __('ui.create_custom.checkout.selected_charms') }}</span>
                            <span class="font-semibold text-charcoal">{{ $inquiry->charmDesignItems->count() }} {{ __('ui.create_custom.checkout.charm_s') }}</span>
                        </div>
                        
                        <!-- Charm List -->
                        @if($inquiry->charmDesignItems->count() > 0)
                            <div class="mt-6 pt-6 border-t-2 border-blush-200">
                                <p class="text-sm font-semibold text-charcoal mb-3">{{ __('ui.create_custom.checkout.charm_details') }}</p>
                                <div class="space-y-2">
                                    @foreach($inquiry->charmDesignItems->groupBy(fn($item) => $item->charm->id) as $group)
                                        @php
                                            $charm = $group->first()->charm;
                                            $quantity = $group->count();
                                        @endphp
                                        <div class="flex items-center gap-3 text-sm">
                                            <span class="text-lg">
                                                @switch(strtolower($charm->name ?? ''))
                                                    @case('diamond heart')
                                                    @case('diamond clasp')
                                                        💎
                                                    @break
                                                    @case('pearl accent')
                                                    @case('pearl drop')
                                                    @case('pearl end')
                                                        🔱
                                                    @break
                                                    @case('crystal bead')
                                                    @case('crystal cluster')
                                                        ✨
                                                    @break
                                                    @case('gemstone drop')
                                                    @case('gemstone charm')
                                                    @case('gemstone center')
                                                        💜
                                                    @break
                                                    @case('gold tag')
                                                    @case('ring connector')
                                                        🏆
                                                    @break
                                                    @default
                                                        ⭐
                                                @endswitch
                                            </span>
                                            <div>
                                                <p class="font-semibold text-charcoal">{{ $charm->name }} x{{ $quantity }}</p>
                                                <p class="text-gray-500 text-xs">{{ __('ui.create_custom.checkout.rp') }} {{ number_format($charm->price_add, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    @php
                        $charmRouteParams = [
                            'type' => $inquiry->type,
                            'finish' => $inquiry->finish,
                            'chain_style' => $inquiry->chain_style_id,
                        ];
                        if (!empty($inquiry->chain_size)) {
                            $charmRouteParams['chain_size'] = $inquiry->chain_size;
                        }
                    @endphp

                    <!-- Edit Design Link -->
                    <a href="{{ route('create-custom.charm', $charmRouteParams) }}" 
                       class="text-blush-500 font-semibold text-sm hover:text-blush-600 transition">
                        {{ __('ui.create_custom.checkout.edit_design') }}
                    </a>
                </div>
            </div>

            <!-- Right: Checkout Form -->
            <div class="lg:col-span-1">
                <div class="bg-blush-50 rounded-lg border border-blush-200 p-6 sticky top-32">
                    <h2 class="text-xl font-bold text-charcoal mb-6">{{ __('ui.create_custom.checkout.order_details') }}</h2>

                    <form id="checkout_form" class="space-y-6">
                        @csrf
                        
                        <!-- Delivery Method -->
                        <div>
                            <label class="block text-sm font-semibold text-charcoal mb-2">
                                {{ __('ui.create_custom.checkout.delivery_method') }}
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3">
                                    <input type="radio" name="delivery_method" value="delivery" checked class="delivery-method-radio w-4 h-4 text-blush-500 border-gray-300 focus:ring-blush-500">
                                    <span class="text-sm font-semibold text-charcoal">{{ __('ui.create_custom.checkout.delivery') }}</span>
                                </label>
                                <label class="flex items-center gap-3">
                                    <input type="radio" name="delivery_method" value="pickup" class="delivery-method-radio w-4 h-4 text-blush-500 border-gray-300 focus:ring-blush-500" {{ $allPickupLocations->isEmpty() ? 'disabled' : '' }}>
                                    <span class="text-sm font-semibold text-charcoal">{{ __('ui.create_custom.checkout.pickup') }}</span>
                                </label>
                                <p id="pickup_help_text" class="text-xs text-gray-500 mt-2">
                                    @if($allPickupLocations->isEmpty())
                                        {{ __('ui.create_custom.checkout.no_pickup_locations_available') }}
                                    @else
                                        {{ __('ui.create_custom.checkout.pickup_available_for_your_city') }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Delivery Address -->
                        <div id="address_section">
                            <label for="address_id" class="block text-sm font-semibold text-charcoal mb-2">
                                {{ __('ui.create_custom.checkout.delivery_address') }}
                            </label>
                            <select name="address_id" id="address_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blush-500">
                                <option value="">{{ __('ui.create_custom.checkout.select_an_address') }}</option>
                                @foreach($addresses as $addr)
                                    <option value="{{ $addr->id }}" data-city="{{ strtolower(trim($addr->city)) }}" {{ $addr->is_default ? 'selected' : '' }}>
                                        {{ $addr->recipient_name }} - {{ $addr->street }}, {{ $addr->city }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-2">{{ __('ui.create_custom.checkout.address_needed_for_pickup_availability') }}</p>
                            @if($addresses->isEmpty())
                                <p class="text-red-500 text-sm mt-2">{{ __('ui.create_custom.checkout.please') }} <a href="{{ route('addresses.index') }}" class="font-semibold hover:underline">{{ __('ui.create_custom.checkout.add_an_address') }}</a> {{ __('ui.create_custom.checkout.first') }}</p>
                            @endif
                        </div>

                        <!-- Pickup Location -->
                        <div id="pickup_section" class="hidden">
                            <label for="pickup_location_id" class="block text-sm font-semibold text-charcoal mb-2">
                                {{ __('ui.create_custom.checkout.pickup_location') }}
                            </label>
                            <select name="pickup_location_id" id="pickup_location_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blush-500">
                                <option value="">{{ __('ui.create_custom.checkout.select_a_pickup_location') }}</option>
                                @foreach($allPickupLocations as $location)
                                    <option value="{{ $location->id }}" data-city="{{ strtolower(trim($location->city)) }}">
                                        {{ $location->name }} - {{ $location->address }}, {{ $location->city }}
                                    </option>
                                @endforeach
                            </select>
                            <p id="pickup_location_note" class="text-xs text-gray-500 mt-2">{{ __('ui.create_custom.checkout.select_pickup_location_for_your_city') }}</p>
                        </div>

                        <!-- Gift Option -->
                        <div>
                            <label class="flex items-center gap-3">
                                <input type="checkbox" name="is_gift" id="is_gift" class="w-4 h-4 rounded border-gray-300">
                                <span class="text-sm font-semibold text-charcoal">{{ __('ui.create_custom.checkout.send_as_a_gift') }}</span>
                            </label>
                        </div>

                        <!-- {{ __('ui.create_custom.checkout.gift_message') }} (Hidden by default) -->
                        <div id="gift_message_section" class="hidden">
                            <label for="gift_message" class="block text-sm font-semibold text-charcoal mb-2">
                                {{ __('ui.create_custom.checkout.gift_message') }}
                            </label>
                            <textarea name="gift_message" id="gift_message" rows="3" maxlength="500" placeholder="{{ __('ui.create_custom.checkout.add_a_personal_message') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blush-500 text-sm"></textarea>
                            <p class="text-xs text-gray-500 mt-1"><span id="char_count">0</span>/500</p>
                        </div>

                        <!-- Price Summary -->
                        <div class="space-y-3 pt-6 border-t border-blush-200">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ __('ui.create_custom.checkout.custom_design') }}</span>
                                <span id="price_display" class="font-semibold text-charcoal">{{ __('ui.create_custom.checkout.rp_0') }}</span>
                            </div>
                            <div class="flex justify-between text-base font-bold pt-3 border-t border-blush-100">
                                <span class="text-charcoal">{{ __('ui.create_custom.checkout.total') }}</span>
                                <span id="total_display" class="text-blush-500">{{ __('ui.create_custom.checkout.rp_0') }}</span>
                            </div>
                        </div>

                        <!-- Payment Button -->
                        <button 
                            type="button"
                            onclick="processPayment(this)"
                            class="w-full py-3 bg-blush-500 text-white font-bold rounded-lg hover:bg-blush-600 transition-colors duration-300 mt-6">
                            {{ __('ui.create_custom.checkout.proceed_to_payment') }}
                        </button>

                        <!-- Back Link -->
                        <a href="{{ route('create-custom.charm', $charmRouteParams) }}" 
                           class="block text-center text-sm text-blush-500 hover:text-blush-600 font-semibold transition">
                            {{ __('ui.create_custom.checkout.back_to_design') }}
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle gift message field
document.getElementById('is_gift').addEventListener('change', function() {
    const giftSection = document.getElementById('gift_message_section');
    giftSection.classList.toggle('hidden', !this.checked);
});

// Character count for gift message
document.getElementById('gift_message').addEventListener('input', function() {
    document.getElementById('char_count').textContent = this.value.length;
});

// Capture design preview as PNG image
async function captureDesignPreview() {
    try {
        const element = document.getElementById('design-preview');
        if (!element) {
            console.error('design-preview element not found');
            return null;
        }
        
        // Wait for all images in preview to be fully loaded
        const images = element.querySelectorAll('img');
        console.log('Found ' + images.length + ' images to load');
        
        const imagePromises = Array.from(images).map((img, idx) => {
            return new Promise((resolve) => {
                if (img.complete && img.naturalHeight > 0) {
                    console.log('Image ' + idx + ' already loaded');
                    resolve();
                } else {
                    const timeoutId = setTimeout(() => {
                        console.warn('Image ' + idx + ' timeout after 5s');
                        resolve();
                    }, 5000);
                    
                    img.onload = () => {
                        console.log('Image ' + idx + ' loaded');
                        clearTimeout(timeoutId);
                        resolve();
                    };
                    img.onerror = () => {
                        console.warn('Image ' + idx + ' failed to load');
                        clearTimeout(timeoutId);
                        resolve();
                    };
                }
            });
        });
        
        // Wait for all images to load
        await Promise.all(imagePromises);
        console.log('All images loaded');

        // Extra frames + delay to ensure DOM layout (including absolute charms) is fully stable
        await new Promise(resolve => {
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    setTimeout(resolve, 500);
                });
            });
        });

        // Load html2canvas if not already loaded
        if (typeof html2canvas === 'undefined') {
            console.log('Loading html2canvas library...');
            await new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
                script.onload = () => {
                    console.log('html2canvas loaded');
                    resolve();
                };
                script.onerror = () => {
                    console.error('Failed to load html2canvas');
                    reject(new Error('html2canvas not available'));
                };
                document.head.appendChild(script);
            });
        }

        console.log('Capturing design preview with html2canvas...');
        const canvas = await html2canvas(element, {
            backgroundColor: '#fff5f8',
            scale: 2,
            useCORS: true,
            allowTaint: true,
            logging: false,
            imageTimeout: 8000,
            onclone: (clonedDocument) => {
                // Ensure all positioned elements are visible in clone
                const clonedCharms = clonedDocument.querySelectorAll('[style*="position"]');
                clonedCharms.forEach(charm => {
                    charm.style.visibility = 'visible';
                });
            }
        });
        
        const dataUrl = canvas.toDataURL('image/png');
        console.log('Capture successful, size: ' + (dataUrl.length / 1024).toFixed(2) + ' KB');
        return dataUrl;
    } catch (error) {
        console.error('Error capturing design preview:', error);
        return null;
    }
}


// Calculate total price
function calculateTotal() {
    const basePrice = {{ $calculatedTotal - $inquiry->charmDesignItems->sum(fn ($item) => (float) ($item->charm->price_add ?? 0)) }};
    const charmAddons = {{ $inquiry->charmDesignItems->sum(fn ($item) => (float) ($item->charm->price_add ?? 0)) }};
    const total = basePrice + charmAddons;
    
    const formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    });
    
    document.getElementById('price_display').textContent = formatter.format(total);
    document.getElementById('total_display').textContent = formatter.format(total);
    
    return total;
}

// Process payment
async function processPayment(button) {
    const addressId = document.getElementById('address_id').value;
    const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked')?.value || 'delivery';
    const pickupLocationId = document.getElementById('pickup_location_id')?.value;
    const isGift = document.getElementById('is_gift').checked;
    const giftMessage = document.getElementById('gift_message').value;
    const totalPrice = calculateTotal();

    if (!addressId) {
        alert('{{ __('ui.create_custom.checkout.please') }} select a delivery address');
        return;
    }

    if (deliveryMethod === 'pickup' && !pickupLocationId) {
        alert('{{ __('ui.create_custom.checkout.please') }} select a pickup location');
        return;
    }

    // Show loading
    button.disabled = true;
    button.textContent = 'Processing...';

    try {
        // Capture design preview
        let designPreviewImage = await captureDesignPreview();
        
        if (!designPreviewImage) {
            console.warn('Design capture failed, sending empty (backend will generate fallback)');
            designPreviewImage = null;
        }
        
        const response = await fetch('{{ route("checkout.custom-design-pay", ["inquiry_id" => $inquiry->id]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                delivery_method: deliveryMethod,
                address_id: parseInt(addressId),
                pickup_location_id: pickupLocationId ? parseInt(pickupLocationId) : null,
                total_price: Math.ceil(totalPrice),
                is_gift: isGift,
                gift_message: giftMessage,
                design_preview_image: designPreviewImage,
            })
        });

        const data = await response.json();

        if (!data.success) {
            alert(data.message || 'Payment failed');
            button.disabled = false;
            button.textContent = '{{ __('ui.create_custom.checkout.proceed_to_payment') }}';
            return;
        }

        // Check if Midtrans Snap is loaded
        if (typeof window.snap === 'undefined') {
            alert('Payment gateway is not loaded. {{ __('ui.create_custom.checkout.please') }} refresh the page and try again.');
            button.disabled = false;
            button.textContent = '{{ __('ui.create_custom.checkout.proceed_to_payment') }}';
            return;
        }

        // Redirect to Midtrans
        if (data.snap_token) {
            window.snap.pay(data.snap_token, {
                onSuccess: async function(result) {
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
                    
                    window.location.href = '{{ route("checkout.success") }}?order_id=' + data.order_id;
                },
                onPending: function(result) {
                    window.location.href = '{{ route("checkout.pending") }}?order_id=' + data.order_id;
                },
                onError: function(result) {
                    alert('Payment failed');
                    button.disabled = false;
                    button.textContent = '{{ __('ui.create_custom.checkout.proceed_to_payment') }}';
                },
                onClose: function() {
                    button.disabled = false;
                    button.textContent = '{{ __('ui.create_custom.checkout.proceed_to_payment') }}';
                }
            });
        }
    } catch (error) {
        console.error('Payment Error:', error);
        alert('An error occurred. {{ __('ui.create_custom.checkout.please') }} try again: ' + error.message);
        button.disabled = false;
        button.textContent = '{{ __('ui.create_custom.checkout.proceed_to_payment') }}';
    }
}

// Normalize charm position for responsive preview container
function normalizeCharmPositions() {
    const container = document.getElementById('design-preview');
    if (!container) return;

    document.querySelectorAll('.design-charm-item').forEach(el => {
        const originalX = parseFloat(el.dataset.originalX);
        const originalY = parseFloat(el.dataset.originalY);

        if (!isNaN(originalX)) {
            // if value already in percent scale, use that directly
            if (originalX <= 100) {
                el.style.left = originalX + '%';
            } else {
                // legacy pixel values preserved as fallback
                const containerWidth = container.clientWidth;
                el.style.left = Math.round(originalX / 500 * containerWidth) + 'px';
            }
        }

        if (!isNaN(originalY)) {
            if (originalY <= 100) {
                el.style.top = originalY + '%';
            } else {
                const containerHeight = container.clientHeight;
                el.style.top = Math.round(originalY / 500 * containerHeight) + 'px';
            }
        }
    });
}

// Initialize on page load
window.addEventListener('load', function() {
    calculateTotal();
    normalizeCharmPositions();
    updatePickupAvailability();
    togglePickupSection();
});

window.addEventListener('resize', normalizeCharmPositions);

function updatePickupAvailability() {
    const pickupSelect = document.getElementById('pickup_location_id');
    const pickupRadio = document.querySelector('input[name="delivery_method"][value="pickup"]');
    const pickupHelpText = document.getElementById('pickup_help_text');
    const pickupNote = document.getElementById('pickup_location_note');

    if (!pickupSelect || !pickupRadio || !pickupHelpText || !pickupNote) {
        return;
    }

    let availableCount = 0;
    Array.from(pickupSelect.options).forEach(option => {
        if (option.value) {
            option.hidden = false;
            availableCount++;
        }
    });

    const pickupAvailable = availableCount > 0;
    pickupRadio.disabled = !pickupAvailable;

    if (pickupAvailable) {
        pickupHelpText.textContent = '{{ __('ui.create_custom.checkout.pickup_available_for_your_city') }}';
        pickupNote.textContent = '{{ __('ui.create_custom.checkout.select_a_pickup_location') }}';
    } else {
        pickupHelpText.textContent = '{{ __('ui.create_custom.checkout.pickup_unavailable_for_city') }}';
        pickupNote.textContent = '{{ __('ui.create_custom.checkout.pickup_unavailable_for_city') }}';
        const deliveryRadio = document.querySelector('input[name="delivery_method"][value="delivery"]');
        if (pickupRadio.checked && deliveryRadio) {
            deliveryRadio.checked = true;
        }
        document.getElementById('pickup_section').classList.add('hidden');
    }
}

function togglePickupSection() {
    const selectedMethod = document.querySelector('input[name="delivery_method"]:checked')?.value;
    const pickupSection = document.getElementById('pickup_section');
    if (!pickupSection) return;
    pickupSection.classList.toggle('hidden', selectedMethod !== 'pickup');
}

const deliveryRadios = document.querySelectorAll('.delivery-method-radio');
if (deliveryRadios.length > 0) {
    deliveryRadios.forEach(radio => {
        radio.addEventListener('change', togglePickupSection);
    });
}

const addressSelectElement = document.getElementById('address_id');
if (addressSelectElement) {
    addressSelectElement.addEventListener('change', function() {
        updatePickupAvailability();
    });
}
</script>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.midtrans.client_key') }}"></script>
@endpush
</x-app-layout>
