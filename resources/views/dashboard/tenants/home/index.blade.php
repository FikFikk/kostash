@extends('dashboard.tenants.layouts.app')

@section('title', 'Dashboard')

@push('styles')
    {{-- Custom styles for a modern, consistent UI --}}
    <style>
        :root {
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --gradient-info: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-warning: linear-gradient(135deg, #f5af19 0%, #f12711 100%);
            --shadow-elegant: 0 10px 30px rgba(0, 0, 0, 0.08);
            --radius-lg: 1rem;
        }

        .content-card {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-elegant);
        }

        .text-gradient {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .bill-item {
            background: var(--bs-light-bg-subtle);
            border: 1px solid var(--bs-border-color-translucent);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .bill-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-elegant);
            border-color: var(--bs-primary);
        }

        .bill-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.5rem;
            font-size: 1.5rem;
            color: #fff;
        }

        .bill-icon.electric {
            background: var(--gradient-warning);
        }

        .bill-icon.water {
            background: var(--gradient-info);
        }

        .bill-icon.room {
            background: var(--gradient-primary);
        }

        .bill-label {
            font-size: 0.9rem;
            color: var(--bs-secondary-color);
            margin-bottom: 0.25rem;
        }

        .bill-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--bs-heading-color);
        }

        .total-bill-card {
            background: var(--gradient-success);
            color: white;
        }

        .payment-method-card {
            border: 2px solid var(--bs-border-color-translucent);
            border-radius: var(--radius-lg);
            padding: 1.25rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .payment-method-card:hover {
            border-color: var(--bs-primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-elegant);
        }

        .payment-method-card.selected {
            border-color: var(--bs-primary);
            background: var(--bs-primary-bg-subtle);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        .payment-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Snap-like Modal Overlay */
        .payment-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .payment-modal {
            background: white;
            border-radius: 1rem;
            padding: 3rem;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .payment-loader {
            width: 60px;
            height: 60px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1.5rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .payment-success {
            width: 60px;
            height: 60px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 1.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h1 class="h3 fw-bold text-gradient mb-1" id="greeting-text">Selamat datang, {{ $user->name }}!</h1>
                        <p class="text-muted mb-0">Here's your billing summary and profile information.</p>
                    </div>
                    <a href="{{ route('tenant.profile.index') }}" class="btn btn-outline-secondary btn-sm mt-3 mt-lg-0">
                        <i class="ri-user-line me-1"></i> Manage Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card content-card mb-4">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h5 class="mb-0 fw-bold"><i class="ri-calendar-2-line me-2"></i>Pilih Periode Tagihan</h5>
            </div>
            <div class="card-body p-4">
                <form method="GET" action="{{ route('tenant.home') }}" id="filterForm">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-5">
                            <label for="month" class="form-label">Bulan</label>
                            <select name="month" id="month" class="form-select">
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="year" class="form-label">Tahun</label>
                            <select name="year" id="year" class="form-select">
                                @foreach ($availableYears as $y)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                        {{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary w-100 btn-elegant" id="submitBtn">
                                <i class="ri-search-line me-1" id="submitIcon"></i>
                                <span id="submitText">Tampilkan Data</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Billing Details -->
        <div class="card content-card">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center pt-4 px-4">
                <div>
                    <h5 class="mb-0 fw-bold"><i class="ri-bill-line me-2"></i>Ringkasan Tagihan</h5>
                    <p class="text-muted mb-0">Periode: {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                        {{ $year }}</p>
                </div>
                <div>
                    <a href="{{ route('tenant.export', ['month' => $month, 'year' => $year]) }}"
                        class="btn btn-outline-danger btn-sm">
                        <i class="ri-file-pdf-line me-1"></i> Export PDF
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                @if ($meter)
                    @php
                        $electricBill = ($electricUsage ?? 0) * ($global->electric_price ?? 0);
                        $waterBill = ($waterUsage ?? 0) * ($global->water_price ?? 0);
                    @endphp
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="bill-item">
                                <div class="bill-icon electric"><i class="ri-flashlight-line"></i></div>
                                <div>
                                    <p class="bill-label mb-1">Pemakaian Listrik ({{ $electricUsage }} kWh)</p>
                                    <h5 class="bill-value">Rp {{ number_format($electricBill, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="bill-item">
                                <div class="bill-icon water"><i class="ri-water-flash-line"></i></div>
                                <div>
                                    <p class="bill-label mb-1">Pemakaian Air ({{ $waterUsage }} m³)</p>
                                    <h5 class="bill-value">Rp {{ number_format($waterBill, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="bill-item">
                                <div class="bill-icon room"><i class="ri-home-8-line"></i></div>
                                <div>
                                    <p class="bill-label mb-1">Biaya Sewa Kamar</p>
                                    <h5 class="bill-value">Rp {{ number_format($global->monthly_room_price, 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <h4 class="fw-bold">Total Tagihan: <span class="text-success">Rp
                                    {{ number_format($totalBill, 0, ',', '.') }}</span></h4>

                            @if ($paymentStatus === 'success')
                                <div class="alert alert-success border-0 d-flex align-items-center mb-3">
                                    <i class="ri-check-double-line me-2 fs-18"></i>
                                    <div>
                                        <strong>STATUS: LUNAS</strong><br>
                                        <small>Pembayaran berhasil pada
                                            {{ $transaction->paid_at ? $transaction->paid_at->format('d M Y H:i') : '-' }}</small>
                                    </div>
                                </div>
                            @elseif($paymentStatus === 'pending')
                                <div class="alert alert-warning border-0 d-flex align-items-center mb-3">
                                    <i class="ri-time-line me-2 fs-18"></i>
                                    <div>
                                        <strong>STATUS: PENDING</strong><br>
                                        <small>Pembayaran sedang diproses, mohon tunggu konfirmasi</small>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted mb-lg-0">Silakan lakukan pembayaran sebelum tanggal jatuh tempo untuk
                                    menghindari denda.</p>
                            @endif
                        </div>
                        <div class="col-lg-5 text-lg-end">
                            @if ($paymentStatus === 'success')
                                <!-- Tampilkan tombol download receipt atau info lainnya -->
                                <div class="d-grid gap-2">
                                    <span class="badge bg-success-subtle text-success fs-16 p-3">
                                        <i class="ri-shield-check-line me-1"></i> Sudah Lunas
                                    </span>
                                    @if ($transaction)
                                        <a href="{{ route('tenant.download.receipt', $transaction->id) }}"
                                            class="btn btn-outline-success btn-sm" target="_blank">
                                            <i class="ri-download-line me-1"></i> Download Bukti
                                        </a>
                                    @endif
                                </div>
                            @elseif($paymentStatus === 'pending')
                                <!-- Tampilkan status pending dengan tombol check status -->
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-warning btn-lg" disabled>
                                        <i class="ri-time-line me-2"></i> Menunggu Konfirmasi
                                    </button>
                                    <button onclick="checkPaymentStatus('{{ $transaction->order_id }}')"
                                        class="btn btn-outline-warning btn-sm">
                                        <i class="ri-refresh-line me-1"></i> Cek Status
                                    </button>
                                </div>
                            @else
                                <!-- Tampilkan tombol bayar normal -->
                                <button type="button" id="pay-button" class="btn btn-success btn-lg w-100"
                                    data-meter-id="{{ $meter->id ?? '' }}" onclick="handlePayment(this)">
                                    <i class="ri-wallet-3-line me-2"></i> Bayar Sekarang
                                </button>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning border-0 text-center">
                        <i class="ri-information-line me-2"></i>
                        Belum ada data tagihan untuk periode yang dipilih.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Payment Overlay Modal (Snap-like) -->
    <div class="payment-overlay" id="paymentOverlay">
        <div class="payment-modal">
            <div class="payment-loader" id="paymentLoader"></div>
            <div class="payment-success" id="paymentSuccess" style="display: none;">
                <i class="ri-check-line"></i>
            </div>
            <h5 id="paymentTitle">Memproses Pembayaran...</h5>
            <p id="paymentMessage" class="text-muted mb-0">Mohon tunggu, sedang menghubungkan ke Mayar</p>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Production-ready payment function
        function handlePayment(button) {
            const meterId = button.getAttribute('data-meter-id');
            if (!meterId) {
                alert('Meter ID tidak ditemukan');
                return;
            }
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="ri-loader-4-line"></i> Memproses...';
            fetch('/test-mayar-direct', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        meter_id: meterId,
                        payment_method: 'mayar'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.payment_url) {
                        window.location.href = data.payment_url;
                    } else {
                        alert('Payment URL tidak ditemukan');
                    }
                })
                .catch(error => {
                    alert('Gagal membuat pembayaran: ' + error.message);
                })
                .finally(() => {
                    button.disabled = false;
                    button.innerHTML = originalText;
                });
        }
        window.handlePayment = handlePayment;
    </script>
@endsection
