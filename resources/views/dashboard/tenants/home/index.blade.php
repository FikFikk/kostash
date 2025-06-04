@extends('dashboard.tenants.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Dashboard Penyewa</h3>
        <div>
            <a href="{{ route('tenant.profile.index') }}" class="btn btn-outline-secondary btn-elegant">
                <i class="mdi mdi-account-outline me-1"></i> Kelola Profil
            </a>
        </div>
    </div>
    <!-- Card Profile dengan Desain Elegan -->
    <div class="card shadow-lg border-0 mb-4 profile-card">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row align-items-center">
                <!-- Avatar Section -->
                <div class="col-auto">
                    <div class="avatar-container position-relative">
                        @if($user->photo)
                            <img src="{{ asset('storage/uploads/profile/' . $user->photo) }}" 
                                 alt="Profile Picture" 
                                 class="avatar-img rounded-circle shadow-sm" style='object-fit: cover;'>
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=667eea&color=fff&size=120&font-size=0.4"
                                alt="Avatar" class="avatar-img rounded-circle shadow-sm">
                        @endif
                        <div class="avatar-border"></div>
                    </div>
                </div>
                
                <!-- Profile Info -->
                <div class="col text-center text-md-start mt-3 mt-md-0">
                    <div class="profile-info">
                        <h4 class="profile-name mb-2">{{ $user->name }}</h4>
                        <div class="profile-subtitle mb-3">Penyewa Aktif</div>
                        
                        <!-- Info Grid -->
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="mdi mdi-calendar-start"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Tanggal Masuk</div>
                                        <div class="info-value">
                                            {{ $user->date_entry ? \Carbon\Carbon::parse($user->date_entry)->translatedFormat('d F Y') : '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="mdi mdi-home-variant-outline"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Kamar</div>
                                        <div class="info-value">{{ $room->name ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="mdi mdi-email-outline"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Email</div>
                                        <div class="info-value">{{ auth()->user()->email }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card mb-4 filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('tenant.home') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <!-- Pilihan Bulan dan Tahun -->
                    <div class="col-md-6">
                        <label for="month" class="form-label fw-semibold">Periode Tagihan</label>
                        <div class="input-group">
                            <select name="month" id="month" class="form-select">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="year" id="year" class="form-select">
                                @foreach($availableYears as $y)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tombol Tampilkan -->
                    <div class="col-md-3 mt-md-4">
                        <button type="submit" class="btn btn-primary w-100 btn-elegant" id="submitBtn">
                            <i class="ri-search-line me-1" id="submitIcon"></i> 
                            <span id="submitText">Tampilkan</span>
                        </button>
                    </div>

                    <!-- Tombol Export PDF -->
                    <div class="col-md-3 mt-md-4">
                        <a href="{{ route('tenant.export', ['month' => $month, 'year' => $year]) }}" class="btn btn-outline-danger w-100 btn-elegant">
                            <i class="ri-file-pdf-line me-1"></i> Export PDF
                        </a>
                    </div>

                    <div class="col-md-3 mt-md-4">
                        <button type="button" id="pay-button" class="btn btn-success w-100 btn-elegant">
                            <i class="ri-wallet-3-line me-1"></i> Bayar Sekarang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bill Info Card -->
    <div class="card bill-card">
        <div class="card-header bg-transparent border-0 pb-0">
            <h5 class="card-title mb-0 fw-bold">Informasi Tagihan</h5>
        </div>
        <div class="card-body pt-3">
            <div class="room-info mb-3">
                <h6 class="text-primary fw-bold">{{ $room->name ?? '-' }}</h6>
            </div>
            
            @php
                use Carbon\Carbon;
                $current = Carbon::createFromDate($year, $month, 1);
                $prev = $current->copy()->subMonth();
                $startMonth = $prev->locale('id')->translatedFormat('F');
                $endMonth = $current->locale('id')->translatedFormat('F');
            @endphp

            <div class="period-info mb-4">
                <span class="badge bg-light text-dark px-3 py-2">
                    <i class="mdi mdi-calendar-range me-1"></i>
                    Periode: {{ $endMonth }} {{ $year }}
                    <!-- Periode: {{ $startMonth }} → {{ $endMonth }} {{ $year }} -->
                </span>
            </div>

            @if($meter)
                <div class="bill-details">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="bill-item electric">
                                <div class="bill-icon">
                                    <i class="mdi mdi-lightning-bolt"></i>
                                </div>
                                <div class="bill-content">
                                    <div class="bill-label">Pemakaian Listrik</div>
                                    <div class="bill-value">{{ $electricUsage }} kWh</div>
                                    <div class="bill-detail">
                                        {{ $meter->electric_meter_start ?? 0 }} → {{ $meter->electric_meter_end ?? 0 }} kWh
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="bill-item water">
                                <div class="bill-icon">
                                    <i class="mdi mdi-water"></i>
                                </div>
                                <div class="bill-content">
                                    <div class="bill-label">Pemakaian Air</div>
                                    <div class="bill-value">{{ $waterUsage }} m³</div>
                                    <div class="bill-detail">
                                        {{ $meter->water_meter_start ?? 0 }} → {{ $meter->water_meter_end ?? 0 }} m³
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="bill-item fixed">
                                <div class="bill-icon">
                                    <i class="mdi mdi-home-city"></i>
                                </div>
                                <div class="bill-content">
                                    <div class="bill-label">Biaya Tetap</div>
                                    <div class="bill-value">Rp{{ number_format($global->monthly_room_price, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="bill-item total">
                                <div class="bill-icon">
                                    <i class="mdi mdi-cash-multiple"></i>
                                </div>
                                <div class="bill-content">
                                    <div class="bill-label">Total Tagihan</div>
                                    <div class="bill-value total-amount">Rp{{ number_format($totalBill, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning border-0 shadow-sm">
                    <i class="mdi mdi-alert-circle-outline me-2"></i>
                    Belum ada data meteran untuk periode ini.
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Profile Card Styling */
    .profile-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px !important;
        overflow: hidden;
        position: relative;
    }

    .profile-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .profile-card .card-body {
        position: relative;
        z-index: 2;
    }

    .avatar-container {
        margin-right: 1rem;
    }

    .avatar-img {
        width: 100px;
        height: 100px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        transition: transform 0.3s ease;
    }

    .avatar-img:hover {
        transform: scale(1.05);
    }

    .profile-name {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .profile-subtitle {
        font-size: 0.9rem;
        opacity: 0.8;
        font-weight: 500;
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        backdrop-filter: blur(10px);
    }

    .info-icon i {
        font-size: 1.2rem;
        color: white;
    }

    .info-label {
        font-size: 0.8rem;
        opacity: 0.8;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 0.95rem;
        font-weight: 600;
    }

    /* Filter Card */
    .filter-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .btn-elegant {
        border-radius: 10px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-elegant:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    /* Bill Card */
    .bill-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .bill-item {
        background: #f8f9ff;
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        border: 1px solid rgba(102, 126, 234, 0.1);
    }

    .bill-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
    }

    .bill-item.electric { background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); }
    .bill-item.water { background: linear-gradient(135deg, #d1ecf1 0%, #a8e6cf 100%); }
    .bill-item.fixed { background: linear-gradient(135deg, #e2e3e5 0%, #d6d8db 100%); }
    .bill-item.total { 
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border: 2px solid #28a745;
    }

    .bill-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        background: rgba(255, 255, 255, 0.7);
    }

    .bill-icon i {
        font-size: 1.5rem;
        color: #495057;
    }

    .bill-label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .bill-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #343a40;
        margin-bottom: 0.25rem;
    }

    .total-amount {
        color: #28a745 !important;
        font-size: 1.3rem !important;
    }

    .bill-detail {
        font-size: 0.8rem;
        color: #6c757d;
        font-style: italic;
    }

    /* Loading Animation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .mdi-spin {
        animation: spin 1s linear infinite;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-card .row {
            text-align: center;
        }
        
        .avatar-container {
            margin-bottom: 1rem;
        }
        
        .info-item {
            justify-content: center;
            text-align: center;
        }
    }
</style>

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