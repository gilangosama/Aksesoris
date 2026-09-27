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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: #667eea;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #667eea;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
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
            border-left: 4px solid #667eea;
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
            word-break: break-all;
        }
        .amount-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: #667eea;
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
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #777;
        }
        .footer-link {
            color: #667eea;
            text-decoration: none;
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
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>🛍️ PESANAN BARU!</h1>
            <p>Ada pesanan yang masuk ke sistem Anda</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="greeting">
                Halo <strong>Admin</strong>,
            </div>

            <p style="margin-bottom: 25px; color: #666;">
                Sebuah pesanan baru telah diterima dan menunggu untuk diproses. Berikut adalah detail lengkapnya:
            </p>

            <!-- Order Info Section -->
            <div class="section">
                <div class="section-title">📦 Informasi Pesanan</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Order ID</div>
                        <div class="info-value">#{{ $order->order_id }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Database ID</div>
                        <div class="info-value">#{{ $order->id }}</div>
                    </div>
                </div>
                <div class="amount-box">
                    <div class="label">Total Pembayaran</div>
                    <div class="value">Rp {{ $orderAmount }}</div>
                </div>
                <div class="info-item" style="grid-column: span 2;">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="status-badge">{{ strtoupper($order->status) }}</span>
                    </div>
                </div>
            </div>

            <!-- Customer Info Section -->
            <div class="section">
                <div class="section-title">👤 Data Pelanggan</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $customerName }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $customerEmail }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">{{ $customerPhone }}</div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="section">
                <div class="section-title">📋 Produk yang Dipesan</div>
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

            <!-- Timeline Section -->
            <div class="section">
                <div class="section-title">⏰ Waktu Pesanan</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Dibuat</div>
                        <div class="info-value">{{ $order->created_at->format('d F Y H:i:s') }} WIB</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Update Terakhir</div>
                        <div class="info-value">{{ $order->updated_at->format('d F Y H:i:s') }} WIB</div>
                    </div>
                </div>
            </div>

            <!-- CTA Button -->
            <div style="text-align: center;">
                <a href="{{ route('filament.admin.resources.orders.view', $order->id) }}" class="button">
                    Lihat Detail Pesanan di Admin Panel
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p style="margin-bottom: 10px;">
                Email ini dikirim secara otomatis. Jangan balas email ini, gunakan admin panel untuk mengelola pesanan.
            </p>
            <p>
                © 2026 Aksesoris Store. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
