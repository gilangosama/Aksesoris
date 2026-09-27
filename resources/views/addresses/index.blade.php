<x-app-layout>
<div class="min-h-screen bg-gradient-to-b from-white to-blush-50 pt-32 pb-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-charcoal mb-2">{{ __('ui.addresses.index.my_addresses') }}</h1>
            <p class="text-gray-600">{{ __('ui.addresses.index.manage_your_delivery_addresses') }}</p>
        </div>

        <!-- Add Address Button -->
        <button onclick="openAddressModal()" class="mb-8 px-6 py-3 bg-blush-500 text-white font-semibold rounded-lg hover:bg-blush-600 transition">
            {{ __('ui.addresses.index.add_new_address') }}
        </button>

        <!-- Addresses List -->
        @if($addresses->count() > 0)
            <div class="space-y-4">
                @foreach($addresses as $address)
                    <div class="bg-white rounded-lg border border-blush-200 p-6 flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="font-bold text-charcoal mb-2">{{ $address->recipient_name }}</h3>
                            <p class="text-gray-600 text-sm mb-1">{{ $address->street }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                            <p class="text-gray-600 text-sm mb-3">{{ __('ui.addresses.index.phone') }} {{ $address->phone }}</p>
                            @if($address->is_default)
                                <span class="inline-block px-3 py-1 bg-blush-100 text-blush-500 text-xs font-semibold rounded-full">{{ __('ui.addresses.index.default_address') }}</span>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <button onclick="editAddress({{ $address->id }})" class="px-4 py-2 text-blush-500 border border-blush-500 rounded hover:bg-blush-50 text-sm font-semibold">{{ __('ui.addresses.index.edit') }}</button>
                            <button onclick="deleteAddress({{ $address->id }})" class="px-4 py-2 text-red-500 border border-red-500 rounded hover:bg-red-50 text-sm font-semibold">{{ __('ui.addresses.index.delete') }}</button>
                            @if(!$address->is_default)
                                <button onclick="setDefault({{ $address->id }})" class="px-4 py-2 text-gray-500 border border-gray-500 rounded hover:bg-gray-50 text-sm font-semibold">{{ __('ui.addresses.index.set_default') }}</button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg border border-blush-200 p-12 text-center">
                <p class="text-gray-600 mb-4">{{ __('ui.addresses.index.you_haven_t_added_any_addresses_yet') }}</p>
                <button onclick="openAddressModal()" class="px-6 py-3 bg-blush-500 text-white font-semibold rounded-lg hover:bg-blush-600 transition">
                    {{ __('ui.addresses.index.add_your_first_address') }}
                </button>
            </div>
        @endif

        <!-- Back Link -->
        <div class="mt-8">
            <a href="{{ route('home') }}" class="text-blush-500 font-semibold hover:text-blush-600">{{ __('ui.addresses.index.back_to_home') }}</a>
        </div>
    </div>
</div>

<!-- Address Modal -->
<div id="addressModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
        <h2 id="modalTitle" class="text-2xl font-bold text-charcoal mb-6">{{ __('ui.addresses.index.add_new_address') }}</h2>
        
        <form id="addressForm" class="space-y-4">
            @csrf
            <input type="hidden" id="addressId" name="address_id" value="">
            
            <div>
                <label class="block text-sm font-semibold text-charcoal mb-2">{{ __('ui.addresses.index.recipient_name') }}</label>
                <input type="text" name="recipient_name" id="recipient_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blush-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-charcoal mb-2">{{ __('ui.addresses.index.street_address') }}</label>
                <input type="text" name="street" id="street" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blush-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-charcoal mb-2">{{ __('ui.addresses.index.city') }}</label>
                    <input type="text" name="city" id="city" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blush-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-charcoal mb-2">{{ __('ui.addresses.index.province') }}</label>
                    <input type="text" name="province" id="province" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blush-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-charcoal mb-2">{{ __('ui.addresses.index.postal_code') }}</label>
                    <input type="text" name="postal_code" id="postal_code" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blush-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-charcoal mb-2">{{ __('ui.addresses.index.phone') }}</label>
                    <input type="tel" name="phone" id="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blush-500">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_default" name="is_default" class="w-4 h-4">
                <label for="is_default" class="text-sm font-semibold text-charcoal cursor-pointer">{{ __('ui.addresses.index.set_as_default_address') }}</label>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeAddressModal()" class="flex-1 px-4 py-2 border border-gray-300 text-charcoal font-semibold rounded-lg hover:bg-gray-50 transition">
                    {{ __('ui.addresses.index.cancel') }}
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-blush-500 text-white font-semibold rounded-lg hover:bg-blush-600 transition">
                    {{ __('ui.addresses.index.save_address') }}
                </button>
            </div>
        </form>
    </div>
</div>


<style>
.hidden {
    display: none !important;
}
</style>

<script>
// Global functions
window.openAddressModal = function() {
    const modal = document.getElementById('addressModal');
    if (!modal) return;
    document.getElementById('modalTitle').textContent = 'Add New Address';
    document.getElementById('addressForm').reset();
    document.getElementById('addressId').value = '';
    modal.classList.remove('hidden');
};

window.editAddress = function(id) {
    const modal = document.getElementById('addressModal');
    if (!modal) return;
    document.getElementById('modalTitle').textContent = 'Edit Address';
    document.getElementById('addressId').value = id;
    modal.classList.remove('hidden');
};

window.closeAddressModal = function() {
    const modal = document.getElementById('addressModal');
    if (modal) modal.classList.add('hidden');
};

window.saveAddress = async function(e) {
    e.preventDefault();
    
    const csrfToken = document.querySelector('input[name="_token"]').value;
    const addressId = document.getElementById('addressId').value;
    
    const data = {
        recipient_name: document.getElementById('recipient_name').value,
        street: document.getElementById('street').value,
        city: document.getElementById('city').value,
        province: document.getElementById('province').value,
        postal_code: document.getElementById('postal_code').value,
        phone: document.getElementById('phone').value,
        is_default: document.getElementById('is_default').checked ? 1 : 0,
    };
    
    try {
        let url = '/addresses';
        if (addressId) {
            url = `/addresses/${addressId}`;
            data._method = 'PUT';
        }
        
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('✓ Address saved!');
            closeAddressModal();
            location.reload();
        } else {
            alert('Error: ' + (result.message || 'Failed to save'));
        }
    } catch (error) {
        alert('ERROR: ' + error.message);
    }
};

window.deleteAddress = async function(id) {
    if (!confirm('Delete this address?')) return;
    
    const csrfToken = document.querySelector('input[name="_token"]').value;
    
    try {
        const response = await fetch(`/addresses/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('✓ Address deleted!');
            location.reload();
        } else {
            alert('Error: ' + (result.message || 'Failed to delete'));
        }
    } catch (error) {
        alert('ERROR: ' + error.message);
    }
};

window.setDefault = async function(id) {
    const csrfToken = document.querySelector('input[name="_token"]').value;
    
    try {
        const response = await fetch(`/addresses/${id}/set-default`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('✓ Default address updated!');
            location.reload();
        } else {
            alert('Error: ' + (result.message || 'Failed'));
        }
    } catch (error) {
        alert('ERROR: ' + error.message);
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('addressForm');
    if (form) {
        form.addEventListener('submit', window.saveAddress);
    }
    const modal = document.getElementById('addressModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                window.closeAddressModal();
            }
        });
    }
});
</script>

</x-app-layout>
