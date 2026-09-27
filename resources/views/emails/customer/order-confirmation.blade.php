<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .email-header h1 {
            font-size: 28px;
            margin-bottom: 5px;
            font-weight: 700;
        }
        .email-header p {
            font-size: 14px;
            opacity: 0.9;
        }
        .email-body {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 16px;
            margin-bottom: 25px;
            color: #333;
        }
        .greeting strong {
            color: #10b981;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #10b981;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #10b981;
        }
        .order-number-box {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 25px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 30px;
        }
        .order-number-box .label {
            font-size: 12px;
            opacity: 0.9;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .order-number-box .value {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 2px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-item {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #10b981;
        }
        .info-label {
            font-size: 12px;
            color: #777;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        .amount-box {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 20px;
            border-radius: 6px;
            text-align: center;
            margin: 20px 0;
        }
        .amount-box .label {
            font-size: 12px;
            opacity: 0.9;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .amount-box .value {
            font-size: 28px;
            font-weight: 700;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .products-table thead {
            background-color: #f8f9fa;
        }
        .products-table th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: #10b981;
            text-transform: uppercase;
        }
        .products-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .products-table tr:hover {
            background-color: #f8f9fa;
        }
        .timeline {
            padding: 0;
            list-style: none;
        }
        .timeline-item {
            display: flex;
            margin-bottom: 20px;
            padding-left: 40px;
            position: relative;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #10b981;
        }
        .timeline-item strong {
            color: #10b981;
            display: block;
            margin-bottom: 5px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 14px 40px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            margin-top: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #777;
        }
        .status-badge {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .info-grid-full {
            grid-column: 1 / -1;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>✅ Pesanan Dikonfirmasi!</h1>
            <p>Terima kasih telah berbelanja bersama kami</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="greeting">
                Halo <strong>{{ $customerName }}</strong>,
            </div>

            <p style="margin-bottom: 25px; color: #666;">
                Pesanan Anda telah kami terima dengan baik dan sedang dalam tahap pemrosesan. Kami sangat senang melayani Anda!
            </p>

            <!-- Order Number Section -->
            <div class="section">
                <div class="order-number-box">
                    <div class="label">Nomor Pesanan Anda</div>
                    <div class="value">#{{ $orderId }}</div>
                </div>
            </div>

            <!-- Payment Info Section -->
            <div class="section">
                <div class="section-title">💰 Detail Pembayaran</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Jumlah Pesanan</div>
                        <div class="info-value">Rp {{ $orderAmount }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="status-badge">{{ strtoupper($order->status) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="section">
                <div class="section-title">📦 Produk yang Dipesan</div>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td><strong>{{ $item->product_name }}</strong></td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Next Steps Section -->
            <div class="section">
                <div class="section-title">⏭️ Langkah Selanjutnya</div>
                <ul class="timeline">
                    <li class="timeline-item">
                        <strong>✅ Pesanan Diterima</strong>
                        Pesanan Anda telah masuk ke sistem kami
                    </li>
                    <li class="timeline-item">
                        <strong>⏳ Dalam Proses</strong>
                        Tim kami sedang mempersiapkan pesanan Anda
                    </li>
                    <li class="timeline-item">
                        <strong>📦 Siap Dikirim</strong>
                        Pesanan akan dikirim dalam 1-2 hari kerja
                    </li>
                    <li class="timeline-item">
                        <strong>📬 Tracking</strong>
                        Anda akan menerima nomor resi dalam email
                    </li>
                </ul>
            </div>

            <!-- CTA Button -->
            <div style="text-align: center;">
                <a href="{{ route('profile.transactions') }}" class="button">
                    Lihat Status Pesanan
                </a>
            </div>

            <p style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #666; font-size: 14px;">
                Jika ada pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami melalui email atau kunjungi halaman "Hubungi Kami" di website kami.
            </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p style="margin-bottom: 10px;">
                <strong>Aksesoris Store</strong><br>
                Toko aksesoris premium pilihan Anda
            </p>
            <p style="margin-bottom: 0;">
                © 2026 Aksesoris Store. Semua hak terlindungi.
            </p>
        </div>
    </div>
</body>
</html>
