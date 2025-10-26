@extends('dashboard.tenants.layouts.app')

@section('title', 'My Reports')

@push('styles')
{{-- Custom styles for a modern, consistent UI --}}
<style>
    :root {
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-success: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --shadow-elegant: 0 10px 30px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.12);
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
        box-shadow: var(--shadow-hover);
    }
    .stats-icon {
        width: 60px; height: 60px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        background: var(--gradient-primary);
        color: white; font-size: 1.6rem;
    }
    .stats-card.success-card .stats-icon { background: var(--gradient-success); }
    .stats-card.warning-card .stats-icon { background: var(--gradient-warning); }
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
                    <h1 class="h3 fw-bold text-gradient mb-1"><i class="ri-file-list-3-line me-2"></i>My Reports</h1>
                    <p class="text-muted mb-0">Track the status of all your submitted reports.</p>
                </div>
                 <a href="{{ route('tenant.report.create') }}" class="btn btn-primary btn-sm mt-3 mt-lg-0">
                    <i class="ri-add-line me-1"></i> Create New Report
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Total Reports</p>
                            <h3 class="stats-number mb-0">{{ $totalReports ?? 0 }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-file-text-line"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card stats-card warning-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Pending / In Progress</p>
                            <h3 class="stats-number mb-0">{{ $pendingReports ?? 0 }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-time-line"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card stats-card success-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Completed Reports</p>
                            <h3 class="stats-number mb-0">{{ $completedReports ?? 0 }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-checkbox-circle-line"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="card content-card">
        <div class="card-header bg-transparent d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">Report History</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Report Title</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Date Reported</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr>
                            <td>
                                <a href="{{ route('tenant.report.show', $report->id) }}" class="fw-medium">
                                    {{ \Illuminate\Support\Str::limit($report->title, 40) }}
                                </a>
                            </td>
                            <td>
                                <span class="text-muted">{{ $report->category_label }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $report->priority_color }}">{{ $report->priority_label }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $report->reported_at ? $report->reported_at->format('d M Y') : '-' }}</span>
                            </td>
                            <td>
                                 <span class="badge bg-{{ $report->status_color }}">{{ $report->status_label }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('tenant.report.show', $report->id) }}" class="btn btn-sm btn-soft-primary">View Details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="ri-inbox-2-line fs-1 text-muted"></i>
                                <h5 class="mt-2">No reports submitted yet.</h5>
                                <p class="text-muted">Click the button above to create your first report.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($reports->hasPages())
        <div class="card-footer bg-transparent">
            {{ $reports->links('dashboard.tenants.layouts.pagination') }}
        </div>
        @endif
    </div>
</div>
@endsection
