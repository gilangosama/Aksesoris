<x-app-layout>
<div class="min-h-screen bg-gradient-to-b from-white to-blush-50 pt-32 pb-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
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
            <div class="flex items-center gap-2 flex-shrink-0">
                <button class="w-10 h-10 rounded-full bg-blush-500 text-white font-semibold text-sm flex items-center justify-center shadow-soft">4</button>
            </div>
        </div>

        <!-- Charm Position Editor Section -->
        <div id="position_section" class="bg-white rounded-lg border-2 border-blush-200 p-8 mb-12 hidden">
            <h3 class="text-lg font-semibold text-charcoal mb-6 text-center">{{ __('ui.create_custom.select_charm.position_your_charms') }}</h3>
            <p class="text-gray-600 text-sm text-center mb-6">{{ __('ui.create_custom.select_charm.click_and_drag_each_charm_to_position_it_on_your_jewelry') }}</p>
            
            <!-- Interactive Preview Area -->
            <div class="flex flex-col items-center gap-6">
                <!-- Preview Container -->
                <div id="charm_preview_container" class="relative w-full max-w-md mx-auto" style="width: 500px; height: 500px; border: 2px solid #e5b5ca; border-radius: 8px; background: linear-gradient(135deg, #fff5f8 0%, #fce4ec 100%); cursor: crosshair;">
                    
                    <!-- Jewelry Image/Icon (Center) -->
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        @if($chainStyleObj && $chainStyleObj->image)
                            @php
                                $chainImageUrl = $chainStyleObj->image;
                                // If it's a full URL, use directly; if relative path, use asset()
                                if (!filter_var($chainImageUrl, FILTER_VALIDATE_URL)) {
                                    $chainImageUrl = asset('storage/' . $chainImageUrl);
                                }
                            @endphp
                            <img src="{{ $chainImageUrl }}" 
                                 alt="{{ $chainStyleObj->name }}" 
                                 class="max-w-sm max-h-96 object-contain" 
                                 style="filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));">
                        @else
                            <div class="text-center">
                                <div class="text-6xl mb-4">
                                    @switch($jewelry->type)
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
                                <p class="text-gray-600 text-sm">{{ $chainStyleObj->name ?? 'Jewelry' }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Grid Reference Lines -->
                    <div class="absolute inset-0 pointer-events-none" style="background-image: linear-gradient(rgba(229, 181, 202, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(229, 181, 202, 0.1) 1px, transparent 1px); background-size: 50px 50px; border-radius: 6px;"></div>
                </div>
                
                <!-- Selected Charms List -->
                <div class="bg-blush-50 rounded-lg px-6 py-3 w-full max-w-md">
                    <p class="text-sm text-gray-600 mb-2"><strong>{{ __('ui.create_custom.select_charm.selected_charms') }}</strong></p>
                    <div id="selected_charms_list" class="text-sm text-charcoal">
                        <p class="text-gray-400">{{ __('ui.create_custom.select_charm.no_charms_selected_yet') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step Content -->
        <div class="text-center mb-12">
            <p class="text-charcoal text-sm mb-2">{{ __('ui.create_custom.select_charm.step_5_of_5_select_charm_checkout') }}</p>
            <h1 class="text-4xl font-bold text-charcoal mb-2">{{ __('ui.create_custom.select_charm.your_custom') }} {{ $jewelry->label }}</h1>
            @if(!empty($chain_size))
                <p class="text-sm text-blush-600 font-semibold mb-2">Ukuran Chain: {{ $chain_size }}</p>
            @endif
            @if(isset($existingInquiry) && $existingInquiry)
                <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-lg mb-4">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-semibold">Draft Loaded - Continue editing your design</span>
                </div>
            @endif
            <p class="text-gray-600 mb-6">{{ __('ui.create_custom.select_charm.choose_a_charm_to_add_to_your_design') }}</p>

            <!-- Navigation Buttons -->
            <div class="flex justify-center items-center gap-4 mb-6">
                <a href="{{ route('create-custom.chain-style', ['type' => $type, 'finish' => $finish]) }}" 
                   class="px-6 py-3 text-blush-500 font-semibold border-2 border-blush-500 rounded-lg hover:bg-blush-50 transition">
                    {{ __('ui.create_custom.select_charm.previous_step') }}
                </a>

                <button 
                    type="submit"
                    id="checkout_btn"
                    form="charm_form"
                    disabled
                    class="px-8 py-3 bg-gray-300 text-gray-600 font-semibold rounded-lg cursor-not-allowed hover:bg-blush-500 hover:text-white disabled:hover:bg-gray-300 transition">
                    {{ __('ui.create_custom.select_charm.proceed_to_checkout') }}
                </button>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="bg-white rounded-lg border border-blush-200 p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-start md:items-center">
                <!-- Search Charm -->
                <div class="w-full md:flex-1">
                    <div class="relative">
                        <input 
                            type="text" 
                            id="search_charm" 
                            placeholder="{{ __('ui.create_custom.select_charm.search_charms') }}"
                            class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blush-500"
                            onkeyup="filterCharms()">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Selected Counter -->
                <div class="bg-blush-100 rounded-lg px-4 py-2">
                    <p class="text-gray-700 font-semibold">
                        {{ __('ui.create_custom.select_charm.selected_charm') }} <span id="charm_count">0</span>
                    </p>
                </div>
            </div>

            <!-- Quick Search Categories -->
            <div class="mt-6">
                <p class="text-sm font-semibold text-charcoal mb-3">{{ __('ui.create_custom.select_charm.quick_search') }}</p>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="filterByCategory('all')" class="px-4 py-2 rounded-full border-2 border-blush-300 text-charcoal text-sm font-semibold hover:bg-blush-50 transition category-btn active" data-category="all">
                        {{ __('ui.create_custom.select_charm.all_charms') }}
                    </button>
                    <button type="button" onclick="filterByCategory('diamonds')" class="px-4 py-2 rounded-full border-2 border-blush-200 text-charcoal text-sm font-semibold hover:bg-blush-50 transition category-btn" data-category="diamonds">
                        {{ __('ui.create_custom.select_charm.diamonds') }}
                    </button>
                    <button type="button" onclick="filterByCategory('pearls')" class="px-4 py-2 rounded-full border-2 border-blush-200 text-charcoal text-sm font-semibold hover:bg-blush-50 transition category-btn" data-category="pearls">
                        {{ __('ui.create_custom.select_charm.pearls') }}
                    </button>
                    <button type="button" onclick="filterByCategory('crystals')" class="px-4 py-2 rounded-full border-2 border-blush-200 text-charcoal text-sm font-semibold hover:bg-blush-50 transition category-btn" data-category="crystals">
                        {{ __('ui.create_custom.select_charm.crystals') }}
                    </button>
                    <button type="button" onclick="filterByCategory('gemstones')" class="px-4 py-2 rounded-full border-2 border-blush-200 text-charcoal text-sm font-semibold hover:bg-blush-50 transition category-btn" data-category="gemstones">
                        {{ __('ui.create_custom.select_charm.gemstones') }}
                    </button>
                    <button type="button" onclick="filterByCategory('metal')" class="px-4 py-2 rounded-full border-2 border-blush-200 text-charcoal text-sm font-semibold hover:bg-blush-50 transition category-btn" data-category="metal">
                        {{ __('ui.create_custom.select_charm.metal') }}
                    </button>
                </div>
            </div>

            <!-- Hide {{ __('ui.create_custom.select_charm.sold_out_3') }} Toggle -->
            <div class="mt-4 flex items-center gap-3">
                <input type="checkbox" id="hide_sold_out" onclick="toggleSoldOut()" class="w-4 h-4 text-blush-500 border-gray-300 rounded cursor-pointer">
                <label for="hide_sold_out" class="text-sm text-gray-600 cursor-pointer">
                    {{ __('ui.create_custom.select_charm.hide_sold_out_items') }}<span id="sold_count_label">0</span> {{ __('ui.create_custom.select_charm.sold_out') }}
                </label>
            </div>
        </div>

        <!-- Charm Status Summary -->
        <div class="mb-6 flex gap-6 text-sm">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-blush-300 rounded"></span>
                <span class="text-gray-600"><span id="available_count">0</span> {{ __('ui.create_custom.select_charm.available') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-gray-300 rounded"></span>
                <span class="text-gray-600"><span id="sold_count">0</span> {{ __('ui.create_custom.select_charm.sold_out_2') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-blush-500 rounded"></span>
                <span class="text-gray-600">
                    <span id="space_used">0</span> / {{ $totalSpace }} units
                    <span id="space_warning" class="hidden ml-2 text-red-600 font-semibold">⚠️ Limit exceeded!</span>
                </span>
            </div>
        </div>

        <!-- Form for submission -->
        <form method="POST" action="{{ route('create-custom.store') }}" id="charm_form" onsubmit="serializeCharmPositions(event)">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="finish" value="{{ $finish }}">
            <input type="hidden" name="chain_style" value="{{ $chain_style }}">
            <input type="hidden" name="chain_size" value="{{ $chain_size ?? '' }}">
            <input type="hidden" name="charm_positions" id="charm_positions_json" value="{}">

            <!-- Charm Grid -->
            <div class="mb-8">
                <p class="text-gray-600 text-sm mb-4">{{ __('ui.create_custom.select_charm.showing') }} <span id="showing_count">{{ count($charms) }}</span> {{ __('ui.create_custom.select_charm.charm_options') }}</p>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($charms as $charm)
                    <div class="cursor-pointer group charm-card" 
                           data-charm-name="{{ strtolower($charm->name) }}" 
                           data-charm-id="{{ $charm->id }}"
                           data-charm-image="{{ $charm->image ?? '' }}"
                           data-charm-category="{{ $charm->category ?? 'other' }}"
                           data-charm-stock="{{ $charm->stock ?? 0 }}"
                           data-charm-space="{{ $charm->space_required ?? 1 }}"
                           data-sold-out="{{ ($charm->stock ?? 0) == 0 ? 'true' : 'false' }}">
                        <input 
                            type="hidden" 
                            name="charm_quantities[]" 
                            value="{{ $charm->id }}|0" 
                            class="charm-quantity-input"
                            data-charm-id="{{ $charm->id }}"
                            data-max-stock="{{ $charm->stock ?? 999 }}">
                        
                        <div class="relative bg-white rounded-lg border-2 {{ ($charm->stock ?? 1) == 0 ? 'border-gray-300 opacity-60' : 'border-gray-200' }} p-4 transition-all duration-300 group-hover:border-blush-400 group-hover:shadow-lg h-full flex flex-col {{ ($charm->stock ?? 1) == 0 ? '' : '' }}">
                            <!-- Stock Badge -->
                            @if(($charm->stock ?? 0) == 0)
                                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ __('ui.create_custom.select_charm.sold_out_3') }}
                                </span>
                            @elseif($charm->price_add > 0)
                                <span class="absolute top-2 right-2 bg-blush-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ __('ui.create_custom.select_charm.rp') }} {{ number_format($charm->price_add, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ __('ui.create_custom.select_charm.included') }}
                                </span>
                            @endif

                            <!-- Charm Image or Name -->
                            <div class="mb-4 text-center h-32 flex items-center justify-center relative overflow-hidden">
                                @if($charm->image && trim($charm->image) !== '')
                                    @php
                                        $charmImageUrl = $charm->image;
                                        // If it's a full URL, use directly; if relative path, use asset()
                                        if (!filter_var($charmImageUrl, FILTER_VALIDATE_URL)) {
                                            $charmImageUrl = asset('storage/' . $charmImageUrl);
                                        }
                                    @endphp
                                    <img src="{{ $charmImageUrl }}" 
                                         alt="{{ $charm->name }}" 
                                         class="max-h-32 max-w-32 object-contain"
                                         style="object-position: center;">
                                @else
                                    <div class="text-5xl">
                                        @switch(strtolower($charm->name))
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
                                            @case('none-plain chain')
                                            @case('none-plain')
                                            @case('plain setting')
                                                ⭕
                                            @break
                                            @default
                                                ⭐
                                        @endswitch
                                    </div>
                                @endif

                                <div class="charm-info-panel absolute inset-x-0 bottom-0 bg-white/95 border-t border-gray-200 px-3 py-2 text-left text-sm text-gray-700 transform translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                    <div class="font-semibold text-charcoal truncate">{{ $charm->name }}</div>
                                    <div class="text-[11px] text-gray-500 mt-1">
                                        {{ $charm->size ? 'Ukuran: ' . $charm->size : 'Ukuran tidak tersedia' }}
                                    </div>
                                    <div class="text-[11px] text-gray-500 mt-1">
                                        Space: <span class="font-semibold">{{ $charm->space_required ?? 1 }} unit(s)</span>
                                    </div>
                                    <div class="text-[11px] text-gray-500 mt-1">{{ $charm->description ?? 'Deskripsi singkat tidak tersedia' }}</div>
                                </div>
                            </div>

                            <!-- Stock Counter -->
                            @if(($charm->stock ?? 1) > 0)
                                <div class="text-xs text-gray-600 font-semibold px-2 py-1 text-center">
                                    Stock: {{ $charm->stock ?? 999 }}
                                </div>
                            @endif

                            <!-- Quantity Selector -->
                            <div class="mt-auto pt-2 border-t border-gray-200 flex items-center justify-center gap-3">
                                <button type="button" class="qty-btn qty-minus px-2.5 py-1.5 rounded text-sm font-bold bg-gray-300 hover:bg-gray-400 text-gray-700 transition" onclick="adjustQuantity(this, -1)" {{ ($charm->stock ?? 1) == 0 ? 'disabled' : '' }}>−</button>
                                <input 
                                    type="number" 
                                    class="qty-display w-12 px-2 py-1.5 text-center text-base font-bold border-2 border-blush-400 rounded bg-white" 
                                    value="0" 
                                    min="0" 
                                    max="{{ $charm->stock ?? 999 }}"
                                    {{ ($charm->stock ?? 1) == 0 ? 'disabled' : '' }}
                                    onchange="updateSelection(event)">
                                <button type="button" class="qty-btn qty-plus px-2.5 py-1.5 rounded text-sm font-bold bg-blush-400 hover:bg-blush-500 text-white transition" onclick="adjustQuantity(this, 1)" {{ ($charm->stock ?? 1) == 0 ? 'disabled' : '' }}>+</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-600">{{ __('ui.create_custom.select_charm.no_charms_available_for_this_jewelry_type') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
        </form>

        {{-- Errors --}}
        @if($errors->any())
            <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <p class="text-red-700 font-semibold mb-2">{{ __('ui.create_custom.select_charm.please_fix_the_following_errors') }}</p>
                <ul class="text-red-600 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

<script>
function adjustQuantity(button, change) {
    const card = button.closest('.charm-card');
    const qtyDisplay = card.querySelector('.qty-display');
    const currentVal = parseInt(qtyDisplay.value) || 0;
    const maxStock = parseInt(qtyDisplay.max) || 999;
    const newVal = Math.max(0, Math.min(maxStock, currentVal + change));
    qtyDisplay.value = newVal;
    // Trigger update to show position section
    updateSelection(null);
}

function updateSelection(event) {
    // Prevent default behavior if event exists
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    
    // Get all quantity displays
    const qtyInputs = document.querySelectorAll('.qty-display');
    const totalSpace = {{ $totalSpace }};
    let totalCharms = 0;
    let spaceUsed = 0;
    let selectedCharmDetails = [];
    
    qtyInputs.forEach(qtyInput => {
        const qty = parseInt(qtyInput.value) || 0;
        if (qty > 0) {
            const card = qtyInput.closest('.charm-card');
            const charmId = parseInt(card.dataset.charmId);
            const charmName = card.dataset.charmName;
            const spaceRequired = parseInt(card.dataset.charmSpace) || 1;
            
            totalCharms += qty;
            spaceUsed += qty * spaceRequired;
            
            // Store charm details for later use
            for (let i = 0; i < qty; i++) {
                selectedCharmDetails.push({
                    id: charmId,
                    name: charmName,
                    image: card.dataset.charmImage,
                    space: spaceRequired
                });
            }
        }
    });

    // Update display
    const charmCount = document.getElementById('charm_count');
    const spaceUsedEl = document.getElementById('space_used');
    const spaceWarning = document.getElementById('space_warning');
    
    charmCount.textContent = totalCharms;
    spaceUsedEl.textContent = spaceUsed;
    
    // Check if space exceeded
    const spaceExceeded = spaceUsed > totalSpace;
    if (spaceExceeded) {
        spaceWarning.classList.remove('hidden');
    } else {
        spaceWarning.classList.add('hidden');
    }

    const positionSection = document.getElementById('position_section');
    const container = document.getElementById('charm_preview_container');
    const selectedCharmsList = document.getElementById('selected_charms_list');
    const checkoutBtn = document.getElementById('checkout_btn');

    if (totalCharms > 0) {
        // Show position section
        positionSection.classList.remove('hidden');
        
        // Store existing positions before clearing (convert to percentages)
        const existingPositions = {};
        document.querySelectorAll('.charm-draggable-icon').forEach(el => {
            const posId = el.id.replace('charm-draggable-', '');
            const rect = el.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();
            const xPercent = Math.round(((rect.left - containerRect.left + rect.width / 2) / containerRect.width) * 100);
            const yPercent = Math.round(((rect.top - containerRect.top + rect.height / 2) / containerRect.height) * 100);
            existingPositions[posId] = {
                x: xPercent,
                y: yPercent
            };
        });
        
        // Remove old draggable charms
        document.querySelectorAll('.charm-draggable-icon').forEach(el => el.remove());
        
        // Build selection list
        const selectionGroups = {};
        selectedCharmDetails.forEach(charm => {
            if (!selectionGroups[charm.name]) {
                selectionGroups[charm.name] = 0;
            }
            selectionGroups[charm.name]++;
        });
        
        const listHtml = Object.entries(selectionGroups)
            .map(([name, count]) => `<p>${name} <span class="font-semibold">x${count}</span></p>`)
            .join('');
        selectedCharmsList.innerHTML = listHtml;
        
        // Create draggable elements for each charm instance
        selectedCharmDetails.forEach((charm, instanceIdx) => {
            const draggableEl = document.createElement('div');
            const uniqueId = `${charm.id}-instance-${instanceIdx}`;
            draggableEl.id = `charm-draggable-${uniqueId}`;
            
            // Priority: dragState positions (from draft/session) > existing positions > default
            let position = dragState.charmPositions[uniqueId] || existingPositions[uniqueId];
            
            if (!position) {
                position = {
                    x: 50, // 50% center
                    y: 50 + (instanceIdx * 6) // slight offset in percent
                };
            }
            
            // Convert percentages to pixels for styling
            const container = document.getElementById('charm_preview_container');
            const containerRect = container.getBoundingClientRect();
            const left = (position.x / 100) * containerRect.width;
            const top = (position.y / 100) * containerRect.height;
            
            draggableEl.style.left = left + 'px';
            draggableEl.style.top = top + 'px';
            draggableEl.style.transform = 'translate(-50%, -50%)';
            draggableEl.style.userSelect = 'none';
            draggableEl.style.zIndex = (100 + instanceIdx);
            
            // Use image if available, otherwise emoji
            if (charm.image && charm.image.trim() !== '') {
                draggableEl.className = 'charm-draggable-icon absolute w-28 h-28 flex items-center justify-center cursor-grab active:cursor-grabbing rounded-full border-3 border-blush-500 overflow-hidden';
                const img = document.createElement('img');
                img.src = '/storage/' + charm.image;
                img.alt = charm.name;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'contain';
                img.style.objectPosition = 'center';
                img.style.padding = '8px';
                draggableEl.appendChild(img);
            } else {
                draggableEl.className = 'charm-draggable-icon absolute w-28 h-28 flex items-center justify-center cursor-grab active:cursor-grabbing rounded-full border-3 border-blush-500 overflow-hidden';
                const iconMap = {
                    'diamond heart': '💎',
                    'diamond clasp': '💎',
                    'pearl accent': '🔱',
                    'pearl drop': '🔱',
                    'pearl end': '🔱',
                    'crystal bead': '✨',
                    'crystal cluster': '✨',
                    'gemstone drop': '💜',
                    'gemstone charm': '💜',
                    'gemstone center': '💜',
                    'gold tag': '🏆',
                    'ring connector': '🏆',
                    'none-plain chain': '⭕',
                    'none-plain': '⭕',
                    'plain setting': '⭕'
                };
                draggableEl.textContent = iconMap[charm.name] || '⭐';
                draggableEl.style.fontSize = '3rem';
            }
            
            container.appendChild(draggableEl);
            makeCharmDraggable(draggableEl, uniqueId);
        });
        
        // Highlight selected charm cards
        document.querySelectorAll('.charm-card').forEach(card => {
            card.classList.remove('ring-2', 'ring-blush-500');
        });
        qtyInputs.forEach(input => {
            if ((parseInt(input.value) || 0) > 0) {
                input.closest('.charm-card').classList.add('ring-2', 'ring-blush-500');
            }
        });

        // Enable checkout button only if space not exceeded
        if (!spaceExceeded) {
            enableCheckoutButton();
        } else {
            disableCheckoutButton();
        }
    } else {
        // Hide position section
        positionSection.classList.add('hidden');
        
        // Remove draggable charms
        document.querySelectorAll('.charm-draggable-icon').forEach(el => el.remove());
        
        // Clear selection list
        selectedCharmsList.innerHTML = '<p class="text-gray-400">{{ __('ui.create_custom.select_charm.no_charms_selected_yet') }}</p>';

        // Remove highlights
        document.querySelectorAll('.charm-card').forEach(card => {
            card.classList.remove('ring-2', 'ring-blush-500');
        });

        // Disable checkout button
        disableCheckoutButton();
    }
}

function enableCheckoutButton() {
    const checkoutBtn = document.getElementById('checkout_btn');
    checkoutBtn.disabled = false;
    checkoutBtn.classList.remove('bg-gray-300', 'text-gray-600', 'cursor-not-allowed');
    checkoutBtn.classList.add('bg-blush-500', 'text-white', 'hover:bg-blush-600', 'cursor-pointer');
}

function disableCheckoutButton() {
    const checkoutBtn = document.getElementById('checkout_btn');
    checkoutBtn.disabled = true;
    checkoutBtn.classList.add('bg-gray-300', 'text-gray-600', 'cursor-not-allowed');
    checkoutBtn.classList.remove('bg-blush-500', 'text-white', 'hover:bg-blush-600', 'cursor-pointer');
}

// Global drag state
let dragState = {
    isDragging: false,
    currentElement: null,
    currentCharmId: null,
    offsetX: 0,
    offsetY: 0,
    charmPositions: {}
};

function makeCharmDraggable(element, charmId) {
    const container = document.getElementById('charm_preview_container');
    
    element.addEventListener('mousedown', (e) => {
        e.preventDefault();
        dragState.isDragging = true;
        dragState.currentElement = element;
        dragState.currentCharmId = charmId;
        
        const containerRect = container.getBoundingClientRect();
        
        // Since element uses transform: translate(-50%, -50%), 
        // element.style.left/top is the CENTER position
        const elementCenterX = parseFloat(element.style.left);
        const elementCenterY = parseFloat(element.style.top);
        
        // Mouse position relative to container
        const mouseX = e.clientX - containerRect.left;
        const mouseY = e.clientY - containerRect.top;
        
        // Offset from element CENTER to mouse click
        dragState.offsetX = mouseX - elementCenterX;
        dragState.offsetY = mouseY - elementCenterY;
        
        element.style.cursor = 'grabbing';
    });
}

document.addEventListener('mousemove', (e) => {
    if (!dragState.isDragging || !dragState.currentElement) return;
    
    const container = document.getElementById('charm_preview_container');
    const containerRect = container.getBoundingClientRect();
    const element = dragState.currentElement;
    
    // Get element dimensions
    const elementWidth = element.offsetWidth;
    const elementHeight = element.offsetHeight;
    
    // Mouse position relative to container
    const mouseX = e.clientX - containerRect.left;
    const mouseY = e.clientY - containerRect.top;
    
    // Element CENTER position = mouse position - offset from CENTER to click point
    let x = mouseX - dragState.offsetX;
    let y = mouseY - dragState.offsetY;
    
    // Clamp values within container bounds (center-based positioning)
    x = Math.max(elementWidth / 2, Math.min(x, containerRect.width - elementWidth / 2));
    y = Math.max(elementHeight / 2, Math.min(y, containerRect.height - elementHeight / 2));
    
    element.style.left = x + 'px';
    element.style.top = y + 'px';
    
    // Store position as percentages
    const charmId = element.id.replace('charm-draggable-', '');
    const xPercent = Math.round((x / containerRect.width) * 100);
    const yPercent = Math.round((y / containerRect.height) * 100);
    dragState.charmPositions[charmId] = { x: xPercent, y: yPercent };
});

document.addEventListener('mouseup', () => {
    if (dragState.isDragging && dragState.currentElement) {
        dragState.isDragging = false;
        dragState.currentElement.style.cursor = 'grab';
        dragState.currentElement = null;
        dragState.currentCharmId = null;
    }
});

function serializeCharmPositions(event) {
    const qtyInputs = document.querySelectorAll('.qty-display');
    const charmPositions = [];
    const container = document.getElementById('charm_preview_container');
    const containerRect = container.getBoundingClientRect();

    // Build charm array with quantities expanded
    const charmsArray = [];
    qtyInputs.forEach((input, index) => {
        const qty = parseInt(input.value) || 0;
        if (qty > 0) {
            const charmId = parseInt(input.closest('.charm-card').dataset.charmId);
            for (let i = 0; i < qty; i++) {
                charmsArray.push({
                    id: charmId,
                    instanceIdx: i,
                    uniqueId: `${charmId}-instance-${i}`
                });
            }
        }
    });

    // Get positions for each charm instance
    charmsArray.forEach(charmData => {
        const element = document.getElementById(`charm-draggable-${charmData.uniqueId}`);

        let x = null;
        let y = null;

        if (element) {
            x = parseFloat(element.style.left) || dragState.charmPositions[charmData.uniqueId]?.x || (containerRect.width / 2);
            y = parseFloat(element.style.top) || dragState.charmPositions[charmData.uniqueId]?.y || (containerRect.height / 2);
        } else if (dragState.charmPositions[charmData.uniqueId]) {
            x = dragState.charmPositions[charmData.uniqueId].x;
            y = dragState.charmPositions[charmData.uniqueId].y;
        } else {
            x = containerRect.width / 2;
            y = containerRect.height / 2;
        }

        // Convert to percentage
        const xPercent = Math.round((x / containerRect.width) * 100);
        const yPercent = Math.round((y / containerRect.height) * 100);

        charmPositions.push({
            charm_id: charmData.id,
            x: xPercent,
            y: yPercent
        });
    });
    
    // Build hidden inputs for each charm instance
    const charmsArray2 = [];
    qtyInputs.forEach(input => {
        const qty = parseInt(input.value) || 0;
        const charmId = parseInt(input.closest('.charm-card').dataset.charmId);
        for (let i = 0; i < qty; i++) {
            charmsArray2.push(charmId);
        }
    });
    
    // Remove old charm input fields if exist
    document.querySelectorAll('.charm-position-input').forEach(el => el.remove());
    
    // Add new charm input fields
    const form = document.getElementById('charm_form');
    charmsArray2.forEach(charmId => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'charms[]';
        input.value = charmId;
        input.className = 'charm-position-input';
        form.appendChild(input);
    });
    
    // Serialize to JSON
    document.getElementById('charm_positions_json').value = JSON.stringify(charmPositions);
}

function filterCharms() {
    const searchInput = document.getElementById('search_charm').value.toLowerCase();
    const charmCards = document.querySelectorAll('.charm-card');
    const hideSoldOut = document.getElementById('hide_sold_out').checked;

    let visibleCount = 0;
    let availableCount = 0;
    let soldOutCount = 0;

    charmCards.forEach(card => {
        const charmName = card.dataset.charmName;
        const isSoldOut = card.dataset.soldOut === 'true';
        const stock = parseInt(card.dataset.charmStock) || 0;
        
        if (stock > 0) availableCount++;
        if (stock === 0) soldOutCount++;
        
        if (hideSoldOut && isSoldOut) {
            card.style.display = 'none';
        } else if (charmName.includes(searchInput) || searchInput === '') {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    document.getElementById('showing_count').textContent = visibleCount;
    document.getElementById('available_count').textContent = availableCount;
    document.getElementById('sold_count').textContent = soldOutCount;
    document.getElementById('sold_count_label').textContent = soldOutCount;
}

function filterByCategory(category) {
    // Update active button
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.classList.remove('active', 'border-blush-300', 'bg-blush-50');
        btn.classList.add('border-blush-200');
    });
    event.target.classList.add('active', 'border-blush-300', 'bg-blush-50');
    event.target.classList.remove('border-blush-200');
    
    // Filter charms
    const charmCards = document.querySelectorAll('.charm-card');
    const hideSoldOut = document.getElementById('hide_sold_out').checked;
    
    let visibleCount = 0;

    charmCards.forEach(card => {
        const charmCategory = card.dataset.charmCategory;
        const isSoldOut = card.dataset.soldOut === 'true';
        
        if (category === 'all') {
            if (hideSoldOut && isSoldOut) {
                card.style.display = 'none';
            } else {
                card.style.display = '';
                visibleCount++;
            }
        } else {
            if (charmCategory === category && !(hideSoldOut && isSoldOut)) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        }
    });

    document.getElementById('showing_count').textContent = visibleCount;
}

function toggleSoldOut() {
    filterCharms();
}

// Initialize counters on page load
function initializeCounters() {
    const charmCards = document.querySelectorAll('.charm-card');
    let availableCount = 0;
    let soldOutCount = 0;
    
    charmCards.forEach(card => {
        const stock = parseInt(card.dataset.charmStock) || 0;
        if (stock > 0) availableCount++;
        if (stock === 0) soldOutCount++;
    });
    
    document.getElementById('available_count').textContent = availableCount;
    document.getElementById('sold_count').textContent = soldOutCount;
    document.getElementById('sold_count_label').textContent = soldOutCount;
    document.getElementById('showing_count').textContent = charmCards.length;
}

// Initialize on page load
window.addEventListener('load', function() {
    loadDraftData();
    updateSelection();
    initializeCounters();
});

// Reload the page when returning from the browser back-forward cache
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        // Clear any cached positions and reload
        dragState.charmPositions = {};
        window.location.reload();
    }
});

function loadDraftData() {
    @if(isset($selectedCharms) && !empty($selectedCharms))
        // Load selected charms from draft
        const draftCharms = @json($selectedCharms);
        Object.keys(draftCharms).forEach(charmId => {
            const quantity = draftCharms[charmId];
            const card = document.querySelector(`.charm-card[data-charm-id="${charmId}"]`);
            if (card) {
                const qtyInput = card.querySelector('.qty-display');
                if (qtyInput) {
                    qtyInput.value = quantity;
                }
            }
        });

        // Load charm positions from draft
        @if(isset($charmPositions) && !empty($charmPositions))
            const draftPositions = @json($charmPositions);
            draftPositions.forEach(pos => {
                const uniqueId = `${pos.charm_id}-instance-${pos.instance_idx}`;
                dragState.charmPositions[uniqueId] = { x: pos.x, y: pos.y };
            });
        @endif
    @endif
}
</script>

<style>
.charm-card {
    animation: fadeIn 0.3s ease-in;
}

.charm-info-panel {
    pointer-events: none;
}

.charm-card:hover .charm-info-panel {
    pointer-events: auto;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.charm-card:has(input:checked) {
    @apply ring-2 ring-blush-500 border-blush-500;
}
</style>
</x-app-layout>
