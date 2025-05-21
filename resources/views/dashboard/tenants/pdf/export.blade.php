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
      padding: 0;
      background:rgb(255, 255, 255);
      color: #2c3e50;
      font-size: 12px;
    }

    .invoice-container {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); /* Elegan */
        margin: auto;
        padding: 40px;
        max-width: 800px;
        border: 1px solid #e1e5ea; /* Garis tipis luar */
    }

    .header {
      text-align: center;
      padding-bottom: 20px;
      border-bottom: 2px solid #1abc9c;
    }

    .header img {
      height: 70px;
      margin-bottom: 5px;
    }

    .header h1 {
      font-size: 28px;
      color: #1abc9c;
      margin: 0;
    }

    .meta {
      margin: 30px 0;
      display: flex;
      justify-content: space-between;
      font-size: 12px;
    }

    .section-title {
        font-size: 14px;
        font-weight: bold;
        border-left: 5px solid #1abc9c;
        padding-left: 10px;
        color: #2980b9;
        background: #f2fbfa;
        padding: 6px 10px;
        margin-bottom: 10px;
        border-radius: 6px;
    }

    .info-table, .bill-table {
      width: 100%;
      border-collapse: collapse;
    }

    .info-table td {
      padding: 6px 0;
    }

    .bill-table th, .bill-table td {
      padding: 10px;
      border: 1px solid #dee2e6;
    }

    .bill-table th {
        background-color: #ecf0f1;
        color: #2c3e50;
    }

    .text-right {
      text-align: right;
    }

    .total {
        background: #f9f9f9;
        font-weight: bold;
    }

    .highlight {
        background: #fffbe6;
        border-left: 4px solid #f39c12;
        padding: 8px;
        font-size: 11.5px;
        margin-top: 20px;
        border-radius: 6px;
    }

    .thank-you {
      margin-top: 30px;
      font-size: 13px;
      text-align: center;
      color: #16a085;
      font-weight: bold;
    }

    .footer {
      margin-top: 40px;
      text-align: center;
      font-size: 10px;
      color: #aaa;
      border-top: 1px solid #ddd;
      padding-top: 10px;
    }
  </style>
</head>
<body>
  <div class="invoice-container">
    <div class="header">
      <img src="{{ public_path('assets/images/kostash-logo-tp.png') }}" alt="Logo KostASH">
      <h1>Tagihan KostASH</h1>
      <div>{{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</div>
    </div>

    <div class="meta">
      <div>
        <strong>Nama Penghuni:</strong> {{ $user->name }}<br>
        <strong>Kamar:</strong> {{ $room->name }}
      </div>
      <div style="text-align:right;">
        <strong>Tanggal Cetak:</strong><br>{{ now()->format('d F Y') }}<br>
        <!-- <strong>Periode:</strong><br>{{ DateTime::createFromFormat('!m', $month - 1)->format('F') }} -->
        <strong>Periode:</strong><br>{{ DateTime::createFromFormat('!m', $month)->format('F') }}
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
          <td>{{ $meter?->electric_meter_start ?? 0 }} - {{ $meter?->electric_meter_end ?? 0 }} ({{ $electricUsage }} kWh)</td>
          <td class="text-right">{{ number_format($electricUsage * $global->electric_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td>Penggunaan Air</td>
          <td>{{ $meter?->water_meter_start ?? 0 }} - {{ $meter?->water_meter_end ?? 0 }} ({{ $waterUsage }} m³)</td>
          <td class="text-right">{{ number_format($waterUsage * $global->water_price, 0, ',', '.') }}</td>
        </tr>
        <tr class="total">
          <td colspan="2" class="text-right">Total Tagihan</td>
          <td class="text-right">Rp{{ number_format($totalBill, 0, ',', '.') }}</td>
        </tr>
      </tbody>
    </table>

    <div class="highlight">
      💡 Pembayaran sebelum tanggal 10 bulan ini akan membantu menjaga layanan tetap lancar tanpa denda keterlambatan.
    </div>

    <div class="thank-you">
      ❤️ Terima kasih telah tinggal di KostASH. Kepuasan dan kenyamanan Anda adalah prioritas kami.
    </div>

    <div class="footer">
      KostASH.id &bull; PH4Q+X6G, RT.02/RW.01, Plosorejo, Menganti, Kec. Menganti, Kabupaten Gresik, Jawa Timur 61174 <br>
      WA: 0812-xxx-xxx | Email: admin@kostash.id
    </div>
  </div>
</body>
