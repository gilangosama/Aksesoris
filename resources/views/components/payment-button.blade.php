<!-- Payment Button Component -->
<div class="payment-container" id="payment-{{ $id ?? 'default' }}">
    <button 
        type="button"
        id="pay-button-{{ $id ?? 'default' }}"
        class="btn btn-primary px-8 py-3 font-semibold text-white rounded-lg hover:shadow-lg transition-all"
    >
        {{ $buttonText ?? 'Pembayaran Sekarang' }}
    </button>
</div>

@once
<script src="https://app.sandbox.midtrans.com/snap/snap.js" 
    data-client-key="{{ config('services.midtrans.client_key') }}"></script>
@endonce

<script>
(function() {
    const payButton = document.getElementById('pay-button-{{ $id ?? 'default' }}');
    const container = document.getElementById('payment-{{ $id ?? 'default' }}');
    
    if (payButton) {
        payButton.addEventListener('click', function() {
            processPayment();
        });
    }

    function processPayment() {
        const amount = {{ $amount ?? 'null' }};
        const customerName = "{{ $customerName ?? 'Guest' }}";
        const customerEmail = "{{ $customerEmail ?? 'guest@example.com' }}";
        const description = "{{ $description ?? 'Custom Order' }}";

        if (!amount || amount < 10000) {
            alert('Jumlah pembayaran minimal Rp 10.000');
            return;
        }

        // Get form data from checkout form if exists
        let formData = {};
        const addressForm = document.getElementById('address-form');
        if (addressForm) {
            const form = new FormData(addressForm);
            const customerPhone = document.getElementById('customer_phone')?.value;
            const addressId = form.get('address_id');
            const address = form.get('address');

            if (!customerPhone) {
                alert('Nomor telepon harus diisi');
                return;
            }

            if (!addressId && !address) {
                alert('Alamat pengiriman harus dipilih atau diisi');
                return;
            }

            formData = {
                address_id: addressId || null,
                address: address || null,
                customer_phone: customerPhone
            };
        }

        // Show loading state
        payButton.disabled = true;
        payButton.innerHTML = 'Sedang memproses...';

        // Get CSRF token - try multiple sources
        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || 
                        document.querySelector('input[name="_token"]')?.value || 
                        '{{ csrf_token() }}';

        fetch('/payment/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                amount: amount,
                customer_name: customerName,
                customer_email: customerEmail,
                description: description,
                address: formData.address || (document.getElementById('address') ? document.getElementById('address').value : null),
                address_id: formData.address_id || null,
                customer_phone: formData.customer_phone || '',
                // For cart items, if available build items payload
                items: window.__cart_items || null
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`HTTP ${response.status}: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            payButton.disabled = false;
            payButton.innerHTML = '{{ $buttonText ?? "Pembayaran Sekarang" }}';

            if (data.success && data.snap_token) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        handlePaymentSuccess(result, data.order_id);
                    },
                    onPending: function(result) {
                        handlePaymentPending(result, data.order_id);
                    },
                    onError: function(result) {
                        handlePaymentError(result);
                    },
                    onClose: function() {
                        console.log('Payment popup ditutup');
                    }
                });
            } else {
                alert('Gagal membuat transaksi: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            payButton.disabled = false;
            payButton.innerHTML = '{{ $buttonText ?? "Pembayaran Sekarang" }}';
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
        });
    }

    function handlePaymentSuccess(result, orderId) {
        console.log('Pembayaran berhasil:', result);
        
        // Clear cart session
        fetch('/cart/clear', { 
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).catch(e => console.log('Cart clear:', e));

        // Trigger custom event
        const event = new CustomEvent('paymentSuccess', { detail: { result, orderId } });
        container.dispatchEvent(event);

        // Optional: Show success message
        if (window.showNotification) {
            window.showNotification('Pembayaran berhasil! Terima kasih.', 'success');
        }

        // Optional: Redirect after payment
        if ('{{ $successUrl ?? null }}') {
            setTimeout(() => {
                window.location.href = '{{ $successUrl }}';
            }, 2000);
        }
    }

    function handlePaymentPending(result, orderId) {
        console.log('Pembayaran tertunda:', result);
        
        const event = new CustomEvent('paymentPending', { detail: { result, orderId } });
        container.dispatchEvent(event);

        if (window.showNotification) {
            window.showNotification('Pembayaran tertunda. Silakan selesaikan proses.', 'warning');
        }
    }

    function handlePaymentError(result) {
        console.log('Pembayaran gagal:', result);
        
        const event = new CustomEvent('paymentError', { detail: result });
        container.dispatchEvent(event);

        if (window.showNotification) {
            window.showNotification('Pembayaran gagal. Silakan coba lagi.', 'error');
        }
    }
})();
</script>

<style>
.payment-container {
    display: inline-block;
    width: 100%;
}

#pay-button-default {
    background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
    transition: all 0.3s ease;
}

#pay-button-default:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3);
}

#pay-button-default:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
