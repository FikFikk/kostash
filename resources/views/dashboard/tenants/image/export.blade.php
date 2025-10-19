<head>
    <meta charset="UTF-8">
    <title>Invoice KostASH</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('DejaVuSans.ttf');
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            background: rgb(255, 255, 255);
            color: #2c3e50;
            font-size: 12px;
            min-height: 100vh;
        }

        .invoice-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            margin: 0 auto;
            padding: 40px;
            max-width: 800px;
            border: 1px solid #e1e5ea;
            position: relative;
            min-height: calc(100vh - 40px);
            display: flex;
            flex-direction: column;
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #1abc9c;
            margin-bottom: 25px;
        }

        .header img {
            height: 70px;
            margin-bottom: 5px;
        }

        .header h1 {
            font-size: 28px;
            color: #1abc9c;
            margin: 5px 0;
        }

        .header .period {
            font-size: 13px;
            color: #555;
            margin-top: 5px;
        }

        .meta {
            margin: 25px 0;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            gap: 20px;
        }

        .meta div {
            line-height: 1.8;
        }

        .meta strong {
            color: #2980b9;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            border-left: 5px solid #1abc9c;
            padding-left: 10px;
            color: #2980b9;
            background: #f2fbfa;
            padding: 6px 10px;
            margin-top: 20px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .bill-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .bill-table th,
        .bill-table td {
            padding: 10px;
            border: 1px solid #dee2e6;
        }

        .bill-table th {
            background-color: #ecf0f1;
            color: #2c3e50;
            font-weight: bold;
        }

        .bill-table tbody tr:nth-child(odd) {
            background-color: #fafafa;
        }

        .text-right {
            text-align: right;
        }

        .total {
            background: #e8f8f5;
            font-weight: bold;
            font-size: 13px;
        }

        .total td {
            color: #16a085;
        }

        .highlight {
            background: #fffbe6;
            border-left: 4px solid #f39c12;
            padding: 10px 12px;
            font-size: 11.5px;
            margin: 20px 0;
            border-radius: 6px;
            line-height: 1.6;
        }

        .thank-you {
            margin: 25px 0 0 0;
            font-size: 13px;
            text-align: center;
            color: #16a085;
            font-weight: bold;
            padding: 15px;
            background: linear-gradient(135deg, #e8f8f5 0%, #d4f1f4 100%);
            border-radius: 8px;
            line-height: 1.8;
        }

        .content-wrapper {
            flex: 1;
        }

        .footer-1 {
            margin-top: 20px;
            padding-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 2px solid #e1e5ea;
            line-height: 1.6;
            clear: both;
        }

        .footer-brand {
            color: #1abc9c;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .footer-address {
            color: #666;
            margin-bottom: 5px;
            font-size: 9px;
            line-height: 1.5;
        }

        .footer-contact {
            color: #888;
            font-size: 9px;
            margin-top: 5px;
            padding-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="content-wrapper">
            <div class="header">
                <img src="{{ asset('assets/images/kostash-logo-tp.png') }}" alt="Logo KostASH">
                <h1>Tagihan</h1>
                <div class="period">{{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</div>
            </div>

            <div class="meta">
                <div>
                    <strong>Nama Penghuni:</strong> {{ $user->name }}<br>
                    <strong>Kamar:</strong> {{ $room->name }}
                </div>
                <div style="text-align:right;">
                    <strong>Tanggal Cetak:</strong> {{ now()->format('d F Y') }}<br>
                    <strong>Periode:</strong> {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                </div>
            </div>

            <div class="section-title">Rincian Tagihan</div>
            <table class="bill-table">
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th>Detail</th>
                        <th class="text-right">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Biaya Kamar</td>
                        <td>1 Bulan</td>
                        <td class="text-right">{{ number_format($global->monthly_room_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Penggunaan Listrik</td>
                        <td>{{ $meter?->electric_meter_start ?? 0 }} - {{ $meter?->electric_meter_end ?? 0 }}
                            ({{ $electricUsage }} kWh)</td>
                        <td class="text-right">
                            {{ number_format($electricUsage * $global->electric_price, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Penggunaan Air</td>
                        <td>{{ $meter?->water_meter_start ?? 0 }} - {{ $meter?->water_meter_end ?? 0 }}
                            ({{ $waterUsage }} m³)</td>
                        <td class="text-right">{{ number_format($waterUsage * $global->water_price, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="total">
                        <td colspan="2" class="text-right"><strong>Total Tagihan</strong></td>
                        <td class="text-right"><strong>Rp{{ number_format($totalBill, 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>

            <div class="highlight">
                💡 <strong>Penting:</strong> Pembayaran sebelum tanggal <strong>10 bulan ini</strong> akan membantu
                menjaga layanan tetap lancar tanpa denda keterlambatan.
            </div>

            <div class="thank-you">
                ❤️ Terima kasih telah tinggal di KostASH.<br>
                Kepuasan dan kenyamanan Anda adalah prioritas kami.
            </div>
        </div>

        <div class="footer-1">
            <div class="footer-brand">KostASH.my.id</div>
            <div class="footer-address">PH4Q+X6G, RT.02/RW.01, Plosorejo, Menganti, Kec. Menganti, Kabupaten Gresik,
                Jawa Timur 61174</div>
            <div class="footer-contact">WA: 0813-1579-3349 | Email: fikfikk14@gmail.com</div>
        </div>
    </div>
</body>
