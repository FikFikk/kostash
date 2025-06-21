@extends('dashboard.admin.layouts.app')

@section('title', 'User Management')

@push('styles')
{{-- Custom styles to match the modern dashboard UI --}}
<style>
    :root {
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-success: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --gradient-info: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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
    .action-buttons .btn {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
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
                    <h1 class="h3 fw-bold text-gradient mb-1"><i class="ri-team-line me-2"></i>User Management</h1>
                    <p class="text-muted mb-0">Manage all registered users, tenants, and administrators.</p>
                </div>
                 <a href="{{ route('dashboard.user.create') }}" class="btn btn-primary btn-sm mt-3 mt-lg-0">
                    <i class="ri-add-line me-1"></i> Add New User
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Total Users</p>
                            <h3 class="stats-number mb-0">{{ $totalUsers ?? 0 }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-team-fill"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card stats-card success-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Active Tenants</p>
                            <h3 class="stats-number mb-0">{{ $totalTenants ?? 0 }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-user-3-fill"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="stats-label mb-0">Administrators</p>
                            <h3 class="stats-number mb-0">{{ $totalAdmin ?? 0 }}</h3>
                        </div>
                        <div class="stats-icon"><i class="ri-admin-fill"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card content-card">
        {{-- PERBAIKAN: Menambahkan form untuk fungsionalitas pencarian --}}
        <div class="card-header bg-transparent d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">User List</h5>
            <form action="{{ route('dashboard.user.index') }}" method="GET" class="flex-shrink-0">
                <div class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name or email..." value="{{ $search ?? '' }}">
                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover mb-0">
                    <thead>
                        <tr>
                            <th>User Info</th>
                            <th>Role</th>
                            <th>Room</th>
                            <th>Joined Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs me-3 flex-shrink-0">
                                        @if($user->photo)
                                            <img src="{{ asset('storage/uploads/profile/' . $user->photo) }}" alt="" class="img-fluid rounded-circle">
                                        @else
                                             <div class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                        <p class="text-muted mb-0 small">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'success' }}-subtle text-{{ $user->role === 'admin' ? 'danger' : 'success' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $user->room->name ?? '-' }}</span>
                            </td>
                            <td>
                                 <span class="text-muted">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end action-buttons">
                                    <a href="{{ route('dashboard.user.show', $user->id) }}" class="btn btn-sm btn-soft-info" data-bs-toggle="tooltip" title="Details">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    <a href="{{ route('dashboard.user.edit', $user->id) }}" class="btn btn-sm btn-soft-warning" data-bs-toggle="tooltip" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <form action="{{ route('dashboard.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="ri-user-unfollow-line fs-1 text-muted"></i>
                                <h5 class="mt-2">No users found.</h5>
                                @if(isset($search))
                                <p class="text-muted">Try a different search term.</p>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
         @if($users->hasPages())
        <div class="card-footer bg-transparent">
            {{-- PERBAIKAN: Menggunakan withQueryString() agar filter tetap aktif saat paginasi --}}
            {{ $users->withQueryString()->links('dashboard.admin.layouts.pagination') }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
    });
</script>
@endsection
