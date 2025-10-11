<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Bukti Pembayaran - {{ $transaction->order_id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #007bff;
            margin: 0 0 5px 0;
            font-size: 24px;
        }

        .header p {
            margin: 0;
            color: #666;
        }

        .receipt-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .row {
            display: flex;
            margin-bottom: 15px;
        }

        .col-6 {
            width: 50%;
            padding: 0 10px;
        }

        .col-12 {
            width: 100%;
            padding: 0 10px;
        }

        .info-label {
            font-weight: bold;
            color: #495057;
            margin-bottom: 3px;
        }

        .info-value {
            color: #212529;
        }

        .status-success {
            background: #d4edda;
            color: #155724;
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #c3e6cb;
            font-weight: bold;
            text-align: center;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .details-table th,
        .details-table td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
        }

        .details-table th {
            background: #007bff;
            color: white;
            font-weight: bold;
        }

        .details-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .total-row {
            background: #e7f3ff !important;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }

        .qr-code {
            text-align: center;
            margin: 20px 0;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mt-0 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>KOSTASH</h1>
        <p>Bukti Pembayaran Digital</p>
        <p>{{ $global->app_name ?? 'KostASH Management System' }}</p>
    </div>

    <!-- Receipt Information -->
    <div class="receipt-info">
        <div class="row">
            <div class="col-6">
                <div class="info-label">Order ID:</div>
                <div class="info-value">{{ $transaction->order_id }}</div>
            </div>
            <div class="col-6">
                <div class="info-label">Tanggal Pembayaran:</div>
                <div class="info-value">{{ $transaction->paid_at ? $transaction->paid_at->format('d M Y H:i:s') : '-' }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="info-label">Nama Penyewa:</div>
                <div class="info-value">{{ $user->name }}</div>
            </div>
            <div class="col-6">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="info-label">Kamar:</div>
                <div class="info-value">{{ $meter->room->name ?? 'N/A' }}</div>
            </div>
            <div class="col-6">
                <div class="info-label">Periode:</div>
                <div class="info-value">{{ $meter ? $meter->period->format('M Y') : 'N/A' }}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="info-label">Metode Pembayaran:</div>
                <div class="info-value">{{ ucwords(str_replace('_', ' ', $transaction->payment_type)) }}</div>
            </div>
            <div class="col-6">
                <div class="info-label">Status:</div>
                <div class="status-success">LUNAS</div>
            </div>
        </div>
    </div>

    <!-- Payment Details -->
    <table class="details-table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="text-right">Pemakaian</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <!-- Room Rent -->
            <tr>
                <td>Sewa Kamar - {{ $meter->room->name ?? 'Room' }}</td>
                <td class="text-right">1 bulan</td>
                <td class="text-right">Rp {{ number_format($global->monthly_room_price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($global->monthly_room_price, 0, ',', '.') }}</td>
            </tr>

            <!-- Water Usage -->
            @if ($waterUsage > 0)
                <tr>
                    <td>Pemakaian Air</td>
                    <td class="text-right">{{ $waterUsage }} m³</td>
                    <td class="text-right">Rp {{ number_format($global->water_price, 0, ',', '.') }}/m³</td>
                    <td class="text-right">Rp {{ number_format($waterUsage * $global->water_price, 0, ',', '.') }}</td>
                </tr>
            @endif

            <!-- Electric Usage -->
            @if ($electricUsage > 0)
                <tr>
                    <td>Pemakaian Listrik</td>
                    <td class="text-right">{{ $electricUsage }} kWh</td>
                    <td class="text-right">Rp {{ number_format($global->electric_price, 0, ',', '.') }}/kWh</td>
                    <td class="text-right">Rp
                        {{ number_format($electricUsage * $global->electric_price, 0, ',', '.') }}</td>
                </tr>
            @endif

            <!-- Total -->
            <tr class="total-row">
                <td colspan="3"><strong>TOTAL PEMBAYARAN</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Additional Info -->
    <div style="margin-top: 30px;">
        <h4 style="margin-bottom: 10px; color: #007bff;">Informasi Pembayaran:</h4>
        <ul style="margin: 0; padding-left: 20px;">
            <li>Pembayaran telah dikonfirmasi dan berhasil diproses</li>
            <li>Bukti pembayaran ini sah dan dapat digunakan sebagai kwitansi</li>
            <li>Untuk pertanyaan lebih lanjut, hubungi admin kos</li>
            <li>Simpan bukti ini untuk keperluan administrasi</li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate otomatis oleh sistem pada {{ now()->format('d M Y H:i:s') }}</p>
        <p>© {{ date('Y') }} {{ $global->app_name ?? 'KostASH' }} - Semua hak dilindungi</p>
        <p style="margin-top: 10px; font-size: 9px;">
            Untuk verifikasi keaslian dokumen ini, silakan hubungi admin dengan menyertakan Order ID:
            {{ $transaction->order_id }}
        </p>
    </div>
</body>

</html>
