@extends('dashboard.admin.layouts.app')

@section('title', 'Transaction History')

@push('styles')
{{-- Custom styles to match the modern dashboard UI --}}
<style>
    :root {
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-success: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --gradient-danger: linear-gradient(135deg, #ff8c8c 0%, #ff4b4b 100%);
        --shadow-elegant: 0 10px 30px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.12);
    }
    .stats-card {
        border: none;
        border-radius: 1rem;
        box-shadow: var(--shadow-elegant);
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
        position: relative;
    }
    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
    }
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }
    .stats-card.success-card::before { background: var(--gradient-success); }
    .stats-card.warning-card::before { background: var(--gradient-warning); }
    .stats-card.danger-card::before { background: var(--gradient-danger); }
    .stats-icon {
        width: 60px; height: 60px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        background: var(--gradient-primary);
        color: white; font-size: 1.6rem;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.25);
    }
    .success-card .stats-icon { background: var(--gradient-success); box-shadow: 0 8px 20px rgba(67, 233, 123, 0.25); }
    .warning-card .stats-icon { background: var(--gradient-warning); box-shadow: 0 8px 20px rgba(240, 147, 251, 0.25); }
    .danger-card .stats-icon { background: var(--gradient-danger); box-shadow: 0 8px 20px rgba(255, 75, 75, 0.25); }
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
        border-radius: 1rem;
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
        padding: 1rem;
        border-bottom: 2px solid var(--bs-border-color);
    }
    .table-modern td {
        padding: 1rem;
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
                    <h1 class="h3 fw-bold text-gradient mb-1"><i class="ri-history-line me-2"></i>Transaction History</h1>
                    <p class="text-muted mb-0">Monitor all tenant payment activities.</p>
                </div>
                <div class="d-flex gap-2 mt-3 mt-lg-0">
                    <button class="btn btn-primary btn-sm">
                        <i class="ri-download-2-line me-1"></i>Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card success-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Total Revenue</p>
                            <h3 class="stats-number mb-0">Rp{{ number_format($totalRevenue ?? 0) }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-wallet-3-line"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Total Transactions</p>
                            <h3 class="stats-number mb-0">{{ $totalTransactions ?? 0 }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-shopping-cart-line"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card warning-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Pending Payments</p>
                            <h3 class="stats-number mb-0">{{ $pendingTransactions ?? 0 }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-time-line"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card stats-card danger-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Failed/Expired</p>
                            <h3 class="stats-number mb-0">{{ $failedTransactions ?? 0 }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-error-warning-line"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="card content-card">
        <div class="card-header bg-transparent d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">All Transactions</h5>
            <div class="d-flex gap-2">
                <input type="text" class="form-control form-control-sm" placeholder="Search...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Period</th>
                            <th>Status</th>
                            <th>Payment Type</th>
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
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs me-2">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            {{ substr($transaction->user->name ?? 'U', 0, 1) }}
                                        </div>
                                    </div>
                                    <span>{{ $transaction->user->name ?? 'Unknown User' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="fw-medium">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ \Carbon\Carbon::parse($transaction->meter->period)->format('F Y') }}</span>
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
                                <span class="text-muted">{{ ucfirst(str_replace('_', ' ', $transaction->payment_type)) }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $transaction->paid_at ? \Carbon\Carbon::parse($transaction->paid_at)->format('d M Y, H:i') : '-' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="ri-inbox-2-line fs-1 text-muted"></i>
                                <h5 class="mt-2">No transactions found.</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
         @if($transactions->hasPages())
        <div class="card-footer bg-transparent">
            {{ $transactions->links('dashboard.admin.layouts.pagination') }}
        </div>
        @endif
    </div>
</div>
@endsection
