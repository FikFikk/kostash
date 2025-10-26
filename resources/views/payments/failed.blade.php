@extends('public.layouts.app')

@section('title', 'Pembayaran Gagal')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center">
                    <!-- Error Icon -->
                    <div class="mb-4">
                        <div class="avatar-lg mx-auto mb-3">
                            <div class="avatar-title bg-danger-subtle text-danger rounded-circle display-1">
                                <i class="ri-close-line"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Error Message -->
                    <h3 class="text-danger mb-3">Pembayaran Gagal</h3>
                    <p class="text-muted mb-4">
                        Maaf, pembayaran Anda tidak dapat diproses.
                        Silakan coba lagi atau gunakan metode pembayaran lain.
                    </p>

                    <!-- Transaction Details -->
                    @if (isset($transaction))
                        <div class="card border-danger border-opacity-25 mb-4">
                            <div class="card-body">
                                <h6 class="card-title text-danger mb-3">
                                    <i class="ri-file-list-3-line me-1"></i> Detail Transaksi
                                </h6>
                                <div class="row text-start">
                                    <div class="col-6">
                                        <small class="text-muted">Order ID:</small>
                                        <p class="fw-medium mb-2">{{ $transaction->order_id }}</p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Total Bayar:</small>
                                        <p class="fw-medium mb-2">Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Status:</small>
                                        <p class="fw-medium mb-2">
                                            <span class="badge bg-danger">{{ ucfirst($transaction->status) }}</span>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Waktu:</small>
                                        <p class="fw-medium mb-2">
                                            {{ $transaction->updated_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Error Info -->
                    <div class="alert alert-danger border-0 mb-4" role="alert">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <i class="ri-error-warning-line fs-16"></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <strong>Kemungkinan Penyebab:</strong><br>
                                <small>
                                    • Saldo atau limit kartu tidak mencukupi<br>
                                    • Transaksi dibatalkan atau timeout<br>
                                    • Gangguan koneksi saat pembayaran<br>
                                    • Masalah pada sistem bank/e-wallet
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <a href="{{ route('tenant.dashboard') }}" class="btn btn-primary">
                            <i class="ri-repeat-line me-1"></i> Coba Bayar Lagi
                        </a>
                        <a href="{{ route('tenant.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="ri-dashboard-line me-1"></i> Kembali ke Dashboard
                        </a>
                    </div>

                    <!-- Help Section -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="text-muted mb-2">Butuh Bantuan?</h6>
                        <div class="d-flex gap-3 justify-content-center">
                            <small class="text-muted">
                                <i class="ri-phone-line me-1"></i>
                                <a href="tel:+6281234567890" class="text-decoration-none">081234567890</a>
                            </small>
                            <small class="text-muted">
                                <i class="ri-mail-line me-1"></i>
                                <a href="mailto:support@kostash.id" class="text-decoration-none">support@kostash.id</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .min-vh-100 {
            min-height: 100vh;
        }

        .avatar-lg {
            width: 4rem;
            height: 4rem;
        }

        .avatar-title {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }
    </style>
@endpush
