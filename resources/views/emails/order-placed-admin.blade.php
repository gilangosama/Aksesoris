# 🛍️ PESANAN BARU DITERIMA!

Halo Admin,

Ada pesanan baru yang masuk di sistem. Berikut detailnya:

## 📦 Informasi Pesanan

| Detail | Nilai |
|--------|-------|
| **Order ID** | #{{ $order->order_id }} |
| **Database ID** | {{ $order->id }} |
| **Status** | {{ ucfirst($order->status) }} |
| **Total Pembayaran** | Rp {{ $orderAmount }} |

## 👤 Informasi Pelanggan

| Detail | Nilai |
|--------|-------|
| **Nama** | {{ $customerName }} |
| **Email** | {{ $customerEmail }} |
| **No. Telp** | {{ $customerPhone }} |

## � Detail Produk

@foreach($order->items as $item)
- **{{ $item->product_name }}** (Qty: {{ $item->quantity }})
  - Harga: Rp {{ number_format($item->price, 0, ',', '.') }} per unit
  - Subtotal: Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
@endforeach

## ⏰ Waktu Pesanan

- **Dibuat**: {{ $order->created_at->format('d F Y H:i:s') }} (WIB)
- **Updated**: {{ $order->updated_at->format('d F Y H:i:s') }} (WIB)

## 🔗 Aksi Cepat

@component('mail::button', ['url' => route('filament.admin.resources.orders.view', $order->id)])
Lihat Detail Pesanan
@endcomponent

---

**Note**: Email ini dikirim otomatis dari sistem. Jangan reply ke email ini, tapi gunakan admin panel untuk update pesanan.
