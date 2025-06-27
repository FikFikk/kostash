@extends('dashboard.tenants.layouts.app')

@section('title', 'Payment History')

@push('styles')
{{-- Custom styles for a modern, consistent UI --}}
<style>
    :root {
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-success: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --shadow-elegant: 0 10px 30px rgba(0, 0, 0, 0.08);
        --radius-lg: 1rem;
    }
    .stats-card {
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-elegant);
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
        position: relative;
    }
    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }
    .stats-icon {
        width: 60px; height: 60px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        background: var(--gradient-primary);
        color: white; font-size: 1.6rem;
    }
    .stats-card.success-card .stats-icon { background: var(--gradient-success); }
    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.2;
    }
    .stats-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--bs-secondary-color);
    }
    .text-gradient {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .content-card {
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-elegant);
    }
    .table-modern {
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-modern th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.5rem;
        border-bottom: 2px solid var(--bs-border-color);
    }
    .table-modern td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--bs-border-color-translucent);
        vertical-align: middle;
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
                    <h1 class="h3 fw-bold text-gradient mb-1"><i class="ri-history-line me-2"></i>My Payment History</h1>
                    <p class="text-muted mb-0">Review all your past billing and payment records.</p>
                </div>
                 <a href="{{ route('tenant.home') }}" class="btn btn-outline-secondary btn-sm mt-3 mt-lg-0">
                    <i class="ri-arrow-left-line me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card stats-card success-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Total Payments Made</p>
                            <h3 class="stats-number mb-0">Rp{{ number_format($totalPaid ?? 0) }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-wallet-3-fill"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Total Transactions</p>
                            <h3 class="stats-number mb-0">{{ $transactions->total() }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-exchange-dollar-line"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card stats-card">
                 <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Last Payment</p>
                            <h3 class="stats-number mb-0" style="font-size: 1.5rem;">
                                {{ $lastPaymentDate ? $lastPaymentDate->format('d M Y') : 'No payments yet' }}
                            </h3>
                        </div>
                        <div class="stats-icon"><i class="ri-calendar-check-line"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="card content-card">
        <div class="card-header bg-transparent d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">Transaction List</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Amount</th>
                            <th>Period</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                            <th>Paid At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>
                                <span class="fw-medium text-primary">#{{ $transaction->order_id }}</span>
                            </td>
                            <td>
                                <span class="fw-medium">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $transaction->meter ? \Carbon\Carbon::parse($transaction->meter->period)->format('F Y') : 'N/A' }}</span>
                            </td>
                            <td>
                                @switch($transaction->status)
                                    @case('pending')
                                        <span class="badge bg-warning-subtle text-warning">Pending</span>
                                        @break
                                    @case('success')
                                        <span class="badge bg-success-subtle text-success">Success</span>
                                        @break
                                    @case('failed')
                                        <span class="badge bg-danger-subtle text-danger">Failed</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst($transaction->status) }}</span>
                                @endswitch
                            </td>
                            <td>
                                <span class="text-muted">{{ ucfirst(str_replace('_', ' ', $transaction->payment_type ?? '-')) }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $transaction->paid_at ? \Carbon\Carbon::parse($transaction->paid_at)->format('d M Y, H:i') : '-' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="ri-inbox-2-line fs-1 text-muted"></i>
                                <h5 class="mt-2">No payment history found.</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($transactions->hasPages())
        <div class="card-footer bg-transparent">
            {{ $transactions->links('dashboard.tenants.layouts.pagination') }}
        </div>
        @endif
    </div>
</div>
@endsection
