@extends('public.layouts.app')

@section('title', 'Pembayaran Pending')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center">
                    <!-- Pending Icon -->
                    <div class="mb-4">
                        <div class="avatar-lg mx-auto mb-3">
                            <div class="avatar-title bg-warning-subtle text-warning rounded-circle display-1">
                                <i class="ri-time-line"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Message -->
                    <h3 class="text-warning mb-3">Pembayaran Diproses</h3>
                    <p class="text-muted mb-4">
                        Pembayaran Anda sedang dalam proses verifikasi.
                        Silakan tunggu konfirmasi dari sistem pembayaran.
                    </p>

                    <!-- Transaction Details -->
                    @if (isset($transaction))
                        <div class="card border-warning border-opacity-25 mb-4">
                            <div class="card-body">
                                <h6 class="card-title text-warning mb-3">
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
                                            <span
                                                class="badge bg-warning text-dark">{{ ucfirst($transaction->status) }}</span>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Dibuat:</small>
                                        <p class="fw-medium mb-2">
                                            {{ $transaction->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Info Box -->
                    <div class="alert alert-warning border-0 mb-4" role="alert">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <i class="ri-information-line fs-16"></i>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <strong>Catatan Penting:</strong><br>
                                <small>
                                    • Jangan tutup browser sampai pembayaran selesai<br>
                                    • Proses verifikasi biasanya 5-15 menit<br>
                                    • Status akan otomatis terupdate setelah dikonfirmasi
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <a href="{{ route('tenant.dashboard') }}" class="btn btn-warning">
                            <i class="ri-dashboard-line me-1"></i> Kembali ke Dashboard
                        </a>
                        @if (isset($transaction))
                            <button onclick="checkPaymentStatus('{{ $transaction->order_id }}')"
                                class="btn btn-outline-warning">
                                <i class="ri-refresh-line me-1"></i> Cek Status
                            </button>
                        @endif
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted">
                            <i class="ri-customer-service-line me-1"></i>
                            Butuh bantuan? Hubungi admin kos untuk informasi lebih lanjut.
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

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function checkPaymentStatus(orderId) {
            const btn = event.target;
            const originalText = btn.innerHTML;

            btn.innerHTML = '<i class="ri-loader-4-line me-1"></i> Mengecek...';
            btn.disabled = true;

            fetch(`/api/payment/status/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.href = '{{ route('payment.success') }}?order_id=' + orderId;
                    } else if (data.status === 'failed') {
                        window.location.href = '{{ route('payment.failed') }}?order_id=' + orderId;
                    } else {
                        // Status masih pending
                        btn.innerHTML = originalText;
                        btn.disabled = false;

                        // Show toast notification
                        if (typeof Toastify !== 'undefined') {
                            Toastify({
                                text: "Status masih pending. Coba lagi dalam beberapa menit.",
                                duration: 3000,
                                style: {
                                    background: "linear-gradient(to right, #ffc107, #e0a800)",
                                }
                            }).showToast();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
        }
    </script>
@endpush
