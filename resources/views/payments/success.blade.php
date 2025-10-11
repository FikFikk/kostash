@extends('public.layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center">
                    <!-- Success Icon -->
                    <div class="mb-4">
                        <div class="avatar-lg mx-auto mb-3">
                            <div class="avatar-title bg-success-subtle text-success rounded-circle display-1">
                                <i class="ri-check-line"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <h3 class="text-success mb-3">Pembayaran Berhasil!</h3>
                    <p class="text-muted mb-4">
                        Terima kasih, pembayaran Anda telah berhasil diproses.
                        Tagihan kos untuk periode ini telah lunas.
                    </p>

                    <!-- Transaction Details -->
                    @if (isset($transaction))
                        <div class="card border-success border-opacity-25 mb-4">
                            <div class="card-body">
                                <h6 class="card-title text-success mb-3">
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
                                        <small class="text-muted">Metode Bayar:</small>
                                        <p class="fw-medium mb-2 text-capitalize">
                                            {{ str_replace('_', ' ', $transaction->payment_type) }}
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Tanggal Bayar:</small>
                                        <p class="fw-medium mb-2">
                                            {{ $transaction->paid_at ? $transaction->paid_at->format('d M Y H:i') : '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <a href="{{ route('tenant.dashboard') }}" class="btn btn-success">
                            <i class="ri-dashboard-line me-1"></i> Kembali ke Dashboard
                        </a>
                        @if (isset($transaction))
                            <a href="{{ route('tenant.download.receipt', $transaction->id) }}"
                                class="btn btn-outline-success" target="_blank">
                                <i class="ri-download-line me-1"></i> Download Bukti
                            </a>
                        @endif
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted">
                            <i class="ri-information-line me-1"></i>
                            Jika ada pertanyaan, silakan hubungi admin kos.
                        </small>
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

        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }
    </style>
@endpush
