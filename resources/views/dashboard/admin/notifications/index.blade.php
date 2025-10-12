@extends('dashboard.admin.layouts.app')

@section('title', 'Notifications')

@section('content')
    <div class="container-fluid">
        <div class="alert alert-info mb-2">
            <strong>Debug Info:</strong><br>
            User ID: <code>{{ auth()->user()->id }}</code><br>
            Notifiable IDs in DB:
            <code>{{ implode(', ', \App\Models\Notification::pluck('notifiable_id')->toArray()) }}</code>
        </div>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Notifications</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Notifications</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Filter</h5>
                        <ul class="nav nav-pills flex-column mb-4" id="notificationTabs" role="tablist">
                            <li class="nav-item mb-1">
                                <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all"
                                    role="tab">Semua ({{ $counts['all'] }})</a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link" id="transaction-tab" data-bs-toggle="tab" href="#transaction"
                                    role="tab">Transaksi ({{ $counts['transaction'] }})</a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link" id="report-tab" data-bs-toggle="tab" href="#report"
                                    role="tab">Laporan ({{ $counts['report'] }})</a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link" id="system-tab" data-bs-toggle="tab" href="#system"
                                    role="tab">Sistem ({{ $counts['system'] }})</a>
                            </li>
                        </ul>
                        <div class="mt-4">
                            <h6 class="text-uppercase letter-spacing fw-semibold">Statistik</h6>
                            <div class="mt-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-12">Total</span>
                                    <span class="fw-semibold">{{ $counts['all'] }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="text-muted fs-12">Belum Dibaca</span>
                                    <span class="fw-semibold text-danger">{{ $counts['unread'] }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-muted fs-12">Sudah Dibaca</span>
                                    <span class="fw-semibold text-success">{{ $counts['all'] - $counts['unread'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            @if ($counts['unread'] > 0)
                                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-soft-primary w-100 mb-2">
                                        <i class="mdi mdi-check-all me-1"></i> Tandai Semua Dibaca
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="notificationTabContent">
                            <div class="tab-pane fade show active" id="all" role="tabpanel">
                                @include('dashboard.admin.notifications.partials.notification-list', [
                                    'notifications' => $groupedNotifications['all'],
                                ])
                            </div>
                            <div class="tab-pane fade" id="transaction" role="tabpanel">
                                @include('dashboard.admin.notifications.partials.notification-list', [
                                    'notifications' => $groupedNotifications['transaction'],
                                ])
                            </div>
                            <div class="tab-pane fade" id="report" role="tabpanel">
                                @include('dashboard.admin.notifications.partials.notification-list', [
                                    'notifications' => $groupedNotifications['report'],
                                ])
                            </div>
                            <div class="tab-pane fade" id="system" role="tabpanel">
                                @include('dashboard.admin.notifications.partials.notification-list', [
                                    'notifications' => $groupedNotifications['system'],
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
