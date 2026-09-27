# ✅ Pesanan Anda Dikonfirmasi!

Halo {{ $customerName }},

Terima kasih telah berbelanja di Aksesoris! Pesanan Anda telah kami terima dan sedang diproses.

## 📦 Nomor Pesanan Anda

**#{{ $orderId }}**

## 💰 Detail Pembayaran

- Jumlah yang dipesan: **Rp {{ $orderAmount }}**
- Status: **{{ ucfirst($order->status) }}**

## 📋 Produk yang Dipesan

@foreach($order->items as $item)
- **{{ $item->product_name }}** (Qty: {{ $item->quantity }})
  - Harga: Rp {{ number_format($item->price, 0, ',', '.') }} per unit
  - Subtotal: Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
@endforeach

## ⏭️ Langkah Selanjutnya

1. ✅ Pesanan sudah diterima
2. ⏳ Kami akan segera memproses pesanan Anda
3. 📦 Pesan kami akan dikirim dalam 1-2 hari kerja
4. 📬 Anda akan menerima nomor resi tracking

Anda dapat melacak pesanan Anda di website kami atau hubungi kami jika ada pertanyaan.

@component('mail::button', ['url' => route('profile.transactions')])
Lihat Status Pesanan
@endcomponent

---

**Pertanyaan?** Hubungi kami melalui email atau kunjungi halaman "Hubungi Kami" di website.

Terima kasih,  
**Tim Aksesoris Store**
