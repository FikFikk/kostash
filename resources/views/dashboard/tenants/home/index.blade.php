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
        background-color: var(--bs-card-bg);
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
    .bill-icon.electric { background: var(--gradient-warning); }
    .bill-icon.water { background: var(--gradient-info); }
    .bill-icon.room { background: var(--gradient-primary); }
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
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label for="year" class="form-label">Tahun</label>
                        <select name="year" id="year" class="form-select">
                            @foreach($availableYears as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
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
                <p class="text-muted mb-0">Periode: {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</p>
            </div>
            <div>
                 <a href="{{ route('tenant.export', ['month' => $month, 'year' => $year]) }}" class="btn btn-outline-danger btn-sm">
                    <i class="ri-file-pdf-line me-1"></i> Export PDF
                </a>
            </div>
        </div>
        <div class="card-body p-4">
        @if($meter)
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
                            <h5 class="bill-value">Rp {{ number_format($global->monthly_room_price, 0, ',', '.') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h4 class="fw-bold">Total Tagihan: <span class="text-success">Rp {{ number_format($totalBill, 0, ',', '.') }}</span></h4>
                    <p class="text-muted mb-lg-0">Silakan lakukan pembayaran sebelum tanggal jatuh tempo untuk menghindari denda.</p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <button type="button" id="pay-button" class="btn btn-success btn-lg w-100">
                        <i class="ri-wallet-3-line me-2"></i> Bayar Sekarang
                    </button>
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

@endsection

@section('script')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitIcon = document.getElementById('submitIcon');
        const submitText = document.getElementById('submitText');

        form.addEventListener('submit', function(e) {
            // Ubah tampilan tombol menjadi loading
            submitBtn.disabled = true;
            submitBtn.classList.add('disabled');
            
            // Ubah icon menjadi loading spinner
            submitIcon.className = 'mdi mdi-loading mdi-spin me-1';
            submitText.textContent = 'Memuat...';
            
            // Optional: Tambahkan cursor loading pada body
            document.body.style.cursor = 'wait';
        });
    });
</script>

<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        const month = document.getElementById('month').value;
        const year = document.getElementById('year').value;
        
        // Disable button to prevent double click
        const payButton = this;
        payButton.disabled = true;
        payButton.textContent = 'Loading...';

        fetch(`{{ route('tenant.getSnapToken') }}?month=${month}&year=${year}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Re-enable button
            payButton.disabled = false;
            payButton.textContent = 'Bayar Sekarang';
            
            if (data.error) {
                alert(data.error);
                return;
            }

            // Langsung gunakan token yang baru di-generate
            snap.pay(data.token, {
                onSuccess: function(result){
                    console.log("Pembayaran sukses:", result);
                    alert("Pembayaran berhasil! Terima kasih.");
                    location.reload();
                },
                onPending: function(result){
                    console.log("Menunggu pembayaran:", result);
                    alert("Pembayaran masih pending. Silakan selesaikan pembayaran.");
                    location.reload();
                },
                onError: function(result){
                    console.error("Terjadi kesalahan pembayaran:", result);
                    
                    // Jika error karena token expired, coba generate ulang
                    if (result.status_code === '400' || result.status_message.includes('expired')) {
                        alert("Token pembayaran sudah expired. Silakan coba lagi.");
                    } else {
                        alert("Terjadi kesalahan saat pembayaran. Silakan coba lagi.");
                    }
                },
                onClose: function(){
                    console.log("Payment popup closed");
                    // Re-enable button jika user menutup popup
                    payButton.disabled = false;
                    payButton.textContent = 'Bayar Sekarang';
                }
            });
        })
        .catch(error => {
            // Re-enable button
            payButton.disabled = false;
            payButton.textContent = 'Bayar Sekarang';
            
            console.error("Gagal fetch Snap Token:", error);
            alert("Terjadi kesalahan pada server. Silakan coba lagi.");
        });
    });
</script>

@endsection
