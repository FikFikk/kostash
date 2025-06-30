@extends('dashboard.admin.layouts.app')

@section('title', 'Report Management')

@push('styles')
{{-- Custom styles for a modern, consistent UI --}}
<style>
    :root {
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    .form-control, .form-select {
        background-color: var(--bs-tertiary-bg);
        border-color: var(--bs-border-color-translucent);
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
                    <h1 class="h3 fw-bold text-gradient mb-1"><i class="ri-file-list-3-line me-2"></i>Report Management</h1>
                    <p class="text-muted mb-0">Review, filter, and manage all incoming reports from tenants.</p>
                </div>
                <div class="d-flex gap-2 mt-3 mt-lg-0">
                    <a href="{{ route('dashboard.report.statistics') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="ri-pie-chart-line me-1"></i> View Statistics
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card content-card mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.report.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-lg-3 col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                        <option value="in_progress" @selected(request('status') == 'in_progress')>In Progress</option>
                        <option value="completed" @selected(request('status') == 'completed')>Completed</option>
                        <option value="rejected" @selected(request('status') == 'rejected')>Rejected</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $key => $value)
                            <option value="{{ $key }}" @selected(request('category') == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label for="priority" class="form-label">Priority</label>
                    <select name="priority" id="priority" class="form-select">
                        <option value="">All Priorities</option>
                        @foreach($priorities as $key => $value)
                            <option value="{{ $key }}" @selected(request('priority') == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ri-filter-3-line align-bottom me-1"></i> Filter Reports
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reports Table Card -->
    <div class="card content-card">
        <div class="card-header bg-transparent d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">Incoming Reports</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Reporter</th>
                            <th>Report Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs me-2 flex-shrink-0">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            {{ substr($report->user->name ?? 'U', 0, 1) }}
                                        </div>
                                    </div>
                                    <span class="fw-medium">{{ $report->user->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('dashboard.report.show', $report->id) }}" class="text-body">{{ $report->title }}</a>
                                <p class="text-muted mb-0 small">Room: {{ $report->room->name ?? 'N/A' }}</p>
                            </td>
                            <td>{{ $report->category_label }}</td>
                            <td>
                                <span class="text-muted">{{ $report->reported_at ? $report->reported_at->format('d M Y') : '-' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $report->status_color }}">{{ $report->status_label }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('dashboard.report.show', $report->id) }}" class="btn btn-sm btn-soft-primary">Manage</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="ri-inbox-2-line fs-1 text-muted"></i>
                                <h5 class="mt-2">No reports found.</h5>
                                <p class="text-muted">No reports match your current filters.</p>
                                <a href="{{ route('dashboard.report.index') }}" class="btn btn-sm btn-outline-primary">Reset Filters</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($reports->hasPages())
        <div class="card-footer bg-transparent">
            {{ $reports->appends(request()->query())->links('dashboard.admin.layouts.pagination') }}
        </div>
        @endif
    </div>
</div>
@endsection
