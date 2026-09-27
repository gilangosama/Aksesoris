<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
    <div class="max-w-xl">
        <h3 class="text-lg font-semibold text-charcoal mb-6">{{ __('Manage Addresses') }}</h3>

        <!-- Addresses List -->
        <div id="addresses-container" class="space-y-4 mb-6">
            @forelse(auth()->user()->addresses as $address)
                <div class="address-card p-4 border border-blush-200 rounded-lg hover:shadow-md transition" data-address-id="{{ $address->id }}">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <p class="font-medium text-charcoal text-base">{{ $address->address }}</p>
                            <p class="text-sm text-gray-600 mt-1">📞 {{ $address->phone }}</p>
                            @if($address->is_default)
                                <span class="inline-block mt-2 text-xs bg-blush-100 text-blush-700 px-2 py-1 rounded font-semibold">
                                    {{ __('Default Address') }}
                                </span>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            @if(!$address->is_default)
                                <button 
                                    type="button"
                                    class="set-default-btn text-xs px-3 py-1 bg-blush-100 text-blush-700 rounded hover:bg-blush-200 transition"
                                    data-address-id="{{ $address->id }}"
                                >
                                    {{ __('Set Default') }}
                                </button>
                            @endif
                            <button 
                                type="button"
                                class="edit-btn text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition"
                                data-address-id="{{ $address->id }}"
                            >
                                {{ __('Edit') }}
                            </button>
                            <button 
                                type="button"
                                class="delete-btn text-xs px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition"
                                data-address-id="{{ $address->id }}"
                            >
                                {{ __('Delete') }}
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">{{ __('No addresses saved yet.') }}</p>
            @endforelse
        </div>

        <!-- Add New Address Button -->
        <button 
            type="button"
            id="toggle-form-btn"
            class="btn-primary w-full py-2 rounded-lg font-semibold text-white"
        >
            + {{ __('Add New Address') }}
        </button>

        <!-- Add/Edit Address Form -->
        <div id="address-form-container" class="mt-6 pt-6 border-t border-blush-100 opacity-0 pointer-events-none transition-all duration-300">
            <h4 class="font-semibold text-charcoal mb-4" id="form-title">{{ __('Add New Address') }}</h4>
            
            <form id="address-form" class="space-y-4">
                @csrf
                <input type="hidden" id="address-id" name="address_id" value="">

                <div>
                    <label class="block text-sm font-semibold text-charcoal mb-2">{{ __('Address') }}</label>
                    <textarea 
                        id="form-address"
                        name="address"
                        rows="4"
                        class="w-full border border-blush-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blush-400 bg-white"
                        placeholder="{{ __('ui.profile.edit.enter_your_full_address') }}"
                        required
                    ></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-charcoal mb-2">{{ __('ui.profile.edit.phone_number') }}</label>
                    <input 
                        type="tel"
                        id="form-phone"
                        name="phone"
                        class="w-full border border-blush-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blush-400 bg-white"
                        placeholder="{{ __('ui.profile.edit.eg_08123456789') }}"
                        required
                    >
                </div>

                <div class="flex gap-3">
                    <button 
                        type="submit"
                        id="submit-btn"
                        class="flex-1 btn-primary py-2 rounded-lg font-semibold text-white"
                    >
                        {{ __('ui.profile.edit.save_address') }}
                    </button>
                    <button 
                        type="button"
                        id="cancel-form-btn"
                        class="flex-1 btn-outline py-2 rounded-lg font-semibold"
                    >
                        {{ __('Cancel') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const formContainer = document.getElementById('address-form-container');
    const toggleBtn = document.getElementById('toggle-form-btn');
    const cancelBtn = document.getElementById('cancel-form-btn');
    const form = document.getElementById('address-form');
    const formTitle = document.getElementById('form-title');
    const submitBtn = document.getElementById('submit-btn');
    const addressIdInput = document.getElementById('address-id');
    const formAddressInput = document.getElementById('form-address');
    const formPhoneInput = document.getElementById('form-phone');
    const addressesContainer = document.getElementById('addresses-container');

    // Debug check
    if (!formAddressInput || !formPhoneInput) {
        console.error('Form inputs not found!');
        console.log('form-address:', formAddressInput);
        console.log('form-phone:', formPhoneInput);
    }

    // Toggle form visibility
    toggleBtn.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('Toggle button clicked');
        if (formContainer.classList.contains('opacity-0')) {
            formContainer.classList.remove('opacity-0', 'pointer-events-none');
            formContainer.classList.add('opacity-100');
        } else {
            formContainer.classList.add('opacity-0', 'pointer-events-none');
            formContainer.classList.remove('opacity-100');
        }
        if (!formContainer.classList.contains('opacity-0')) {
            resetForm();
            setTimeout(function() {
                formAddressInput.focus();
            }, 100);
        }
    });

    cancelBtn.addEventListener('click', function() {
        formContainer.classList.add('opacity-0', 'pointer-events-none');
        formContainer.classList.remove('opacity-100');
        resetForm();
    });

    // Handle form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const addressId = addressIdInput.value;
        const address = formAddressInput.value;
        const phone = formPhoneInput.value;

        if (!address || !phone) {
            alert('{{ __("Please fill in all fields") }}');
            return;
        }

        const url = addressId 
            ? `/addresses/${addressId}` 
            : '{{ route("addresses.store") }}';
        
        const method = addressId ? 'PUT' : 'POST';

        try {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '{{ __("Saving...") }}';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    address: address,
                    phone: phone
                })
            });

            // Inspect response content-type before parsing JSON
            const contentType = (response.headers.get('content-type') || '').toLowerCase();

            if (!response.ok) {
                // If server returned JSON, show validation/errors
                if (contentType.includes('application/json')) {
                    const data = await response.json();
                    const errorMsg = data.errors ? Object.values(data.errors).flat().join(', ') : data.message || 'Unknown error';
                    alert('{{ __("Error saving address") }}: ' + errorMsg);
                } else {
                    // Non-JSON (likely HTML error or redirect to login)
                    const text = await response.text();
                    console.error('Non-JSON response while saving address:', text);
                    alert('{{ __("Error saving address") }}: Server returned non-JSON response. See console for details.');
                }

                submitBtn.disabled = false;
                submitBtn.innerHTML = addressId ? '{{ __("Update Address") }}' : '{{ __("Save Address") }}';
                return;
            }

            // OK response: try to parse JSON safely
            let data = null;
            try {
                data = contentType.includes('application/json') ? await response.json() : null;
            } catch (e) {
                const text = await response.text();
                console.error('Failed parsing JSON response for save-address:', text);
                alert('{{ __("Error saving address") }}: Invalid server response. See console for details.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = addressId ? '{{ __("Update Address") }}' : '{{ __("Save Address") }}';
                return;
            }

            if (data && data.success) {
                location.reload();
            } else {
                const errorMsg = data && data.errors ? Object.values(data.errors).flat().join(', ') : (data && data.message ? data.message : 'Unknown error');
                alert('{{ __("Error saving address") }}: ' + errorMsg);
                submitBtn.disabled = false;
                submitBtn.innerHTML = addressId ? '{{ __("Update Address") }}' : '{{ __("Save Address") }}';
            }
        } catch (error) {
            console.error('Error:', error);
            alert('{{ __("Error saving address") }}: ' + error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = addressId ? '{{ __("Update Address") }}' : '{{ __("Save Address") }}';
        }
    });

    // Edit address
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const addressId = this.dataset.addressId;
            
            try {
                const response = await fetch(`/addresses/${addressId}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                // Since we don't have a GET endpoint, we'll get data from the card
                const card = document.querySelector(`[data-address-id="${addressId}"]`);
                const addressText = card.querySelector('p.font-medium').textContent;
                const phoneText = card.querySelector('p.text-sm').textContent.replace('📞 ', '');

                addressIdInput.value = addressId;
                formAddressInput.value = addressText;
                formPhoneInput.value = phoneText;
                formTitle.textContent = '{{ __("Edit Address") }}';
                submitBtn.innerHTML = '{{ __("Update Address") }}';
                
                formContainer.classList.remove('opacity-0', 'invisible');
                formContainer.classList.add('opacity-100', 'visible');
                formAddressInput.focus();
            } catch (error) {
                console.error('Error:', error);
                alert('{{ __("Error loading address") }}');
            }
        });
    });

    // Delete address
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            if (!confirm('{{ __("Are you sure you want to delete this address?") }}')) {
                return;
            }

            const addressId = this.dataset.addressId;

            try {
                const response = await fetch(`/addresses/${addressId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });

                const data = await response.json();

                if (data.success) {
                    location.reload();
                } else {
                    alert('{{ __("Error deleting address") }}: ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('{{ __("Error deleting address") }}');
            }
        });
    });

    // Set default address
    document.querySelectorAll('.set-default-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const addressId = this.dataset.addressId;

            try {
                const response = await fetch(`/addresses/${addressId}/set-default`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });

                const data = await response.json();

                if (data.success) {
                    location.reload();
                } else {
                    alert('{{ __("Error setting default address") }}: ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('{{ __("Error setting default address") }}');
            }
        });
    });

    function resetForm() {
        form.reset();
        addressIdInput.value = '';
        formTitle.textContent = '{{ __("Add New Address") }}';
        submitBtn.innerHTML = '{{ __("Save Address") }}';
    }
});
</script>
