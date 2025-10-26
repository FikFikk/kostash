@extends('dashboard.tenants.layouts.app')

@section('title', 'My Profile')

@push('styles')
{{-- Custom styles for a modern, consistent UI --}}
<style>
    :root {
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --shadow-elegant: 0 10px 30px rgba(0, 0, 0, 0.08);
        --radius-lg: 1rem;
    }
    .profile-header-card {
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-elegant);
        background-color: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color-translucent);
    }
    .profile-header-banner {
        height: 120px;
        background: var(--gradient-primary);
        border-top-left-radius: var(--radius-lg);
        border-top-right-radius: var(--radius-lg);
    }
    .profile-avatar {
        margin-top: -60px;
        border: 5px solid var(--bs-card-bg);
    }
    .content-card {
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-elegant);
        background-color: var(--bs-card-bg);
    }
    .info-list .list-group-item {
        background-color: transparent;
        border-color: var(--bs-border-color-translucent);
        padding: 1rem 0;
    }
    .info-list .list-group-item:first-child {
        border-top: none;
    }
    .info-list .list-group-item:last-child {
        border-bottom: none;
    }
    .info-label {
        font-weight: 600;
        color: var(--bs-secondary-color);
        width: 120px;
        flex-shrink: 0;
    }
    .info-value {
        font-weight: 500;
    }
    .text-gradient {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
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
                    <h1 class="h3 fw-bold text-gradient mb-1"><i class="ri-user-settings-line me-2"></i>My Profile</h1>
                    <p class="text-muted mb-0">View and manage your personal and tenancy information.</p>
                </div>
                 <div class="d-flex gap-2 mt-3 mt-lg-0">
                    {{-- PERBAIKAN: Menambahkan tombol kembali ke dashboard --}}
                    <a href="{{ route('tenant.home') }}" class="btn btn-soft-secondary btn-sm">
                        <i class="ri-arrow-left-line me-1"></i> Back to Dashboard
                    </a>
                    <a href="{{ route('tenant.profile.change-password') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="ri-lock-password-line me-1"></i> Change Password
                    </a>
                    <a href="{{ route('tenant.profile.edit') }}" class="btn btn-primary btn-sm">
                        <i class="ri-edit-line me-1"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- User Profile Header -->
    <div class="row">
        <div class="col-12">
            <div class="card profile-header-card mb-4">
                <div class="profile-header-banner"></div>
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row align-items-center">
                        <!-- Avatar -->
                        <div class="avatar-xl profile-avatar flex-shrink-0">
                             @if($user->photo)
                                <img src="{{ asset('storage/uploads/profile/' . $user->photo) }}" alt="Profile" class="img-fluid rounded-circle">
                            @else
                                <div class="avatar-title rounded-circle bg-primary-subtle text-primary fs-24">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <!-- User Info -->
                        <div class="flex-grow-1 ms-md-4 mt-3 mt-md-0 text-center text-md-start">
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <p class="text-muted mb-2">{{ $user->email }}</p>
                            <div>
                                <span class="badge fs-12 bg-success-subtle text-success">Active Tenant</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information Details -->
    <div class="row">
        <!-- Left Column: Personal Info -->
        <div class="col-lg-7">
            <div class="card content-card">
                <div class="card-header bg-transparent p-4">
                    <h5 class="card-title mb-0">Personal Information</h5>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush info-list">
                        <li class="list-group-item d-flex">
                            <span class="info-label">Full Name</span>
                            <span class="info-value">{{ $user->name }}</span>
                        </li>
                        <li class="list-group-item d-flex">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex">
                            <span class="info-label">Phone</span>
                            <span class="info-value">{{ $user->phone ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex">
                            <span class="info-label">NIK</span>
                            <span class="info-value">{{ $user->nik ?? '-' }}</span>
                        </li>
                         <li class="list-group-item d-flex">
                            <span class="info-label">Address</span>
                            <span class="info-value">{{ $user->address ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Right Column: Tenancy Info -->
        <div class="col-lg-5">
            <div class="card content-card">
                <div class="card-header bg-transparent p-4">
                    <h5 class="card-title mb-0">Tenancy Information</h5>
                </div>
                 <div class="card-body p-4">
                    <ul class="list-group list-group-flush info-list">
                         <li class="list-group-item d-flex">
                            <span class="info-label">Room</span>
                            <span class="info-value">{{ $user->room->name ?? 'Not Assigned' }}</span>
                        </li>
                        <li class="list-group-item d-flex">
                            <span class="info-label">Entry Date</span>
                            <span class="info-value">{{ $user->date_entry ? \Carbon\Carbon::parse($user->date_entry)->format('d F Y') : '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex">
                            <span class="info-label">Member Since</span>
                            <span class="info-value">{{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <span class="info-label">Registration</span>
                            <span class="info-value">
                                @if(is_null($user->provider_id))
                                    <i class="ri-mail-line me-1 text-muted"></i> Email & Password
                                @else
                                    <i class="ri-google-fill me-1 text-danger"></i> Registered via Google
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
