@extends('dashboard.tenants.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Kelola Profil</h3>
        <div>
            <a href="{{ route('tenant.profile.edit') }}" class="btn btn-outline-secondary btn-elegant me-2">
                <i class="mdi mdi-account-edit-outline me-1"></i> Edit Profil
            </a>
        </div>
    </div>
    <!-- Card Profile dengan Desain Elegan -->
    <div class="card shadow-lg border-0 mb-4 profile-card">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row align-items-center">
                <!-- Avatar Section -->
                <div class="col-auto">
                    <div class="avatar-container position-relative">
                        @if($user->photo)
                            <img src="{{ asset('storage/uploads/profile/' . $user->photo) }}" 
                                 alt="Profile Picture" 
                                 class="avatar-img rounded-circle shadow-sm">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=667eea&color=fff&size=120&font-size=0.4"
                                alt="Avatar" class="avatar-img rounded-circle shadow-sm">
                        @endif
                        <div class="avatar-border"></div>
                    </div>
                </div>
                
                <!-- Profile Info -->
                <div class="col text-center text-md-start mt-3 mt-md-0">
                    <div class="profile-info">
                        <h4 class="profile-name mb-2">{{ $user->name }}</h4>
                        <div class="profile-subtitle mb-3">
                            <span class="badge bg-light text-dark px-3 py-2">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        
                        <!-- Info Grid -->
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="mdi mdi-email-outline"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Email</div>
                                        <div class="info-value">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="mdi mdi-calendar-start"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Tanggal Masuk</div>
                                        <div class="info-value">
                                            {{ $user->date_entry ? \Carbon\Carbon::parse($user->date_entry)->translatedFormat('d F Y') : '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="mdi mdi-home-variant-outline"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Kamar</div>
                                        <div class="info-value">{{ $user->room->name ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Profile Card -->
    <div class="card detail-card shadow-lg border-0 mb-4">
        <div class="card-header bg-transparent border-0 pb-0">
            <h5 class="card-title mb-0 fw-bold">
                <i class="mdi mdi-account-details-outline me-2"></i>
                Detail Informasi
            </h5>
        </div>
        <div class="card-body pt-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="mdi mdi-account-outline"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Nama Lengkap</div>
                            <div class="detail-value">{{ $user->name }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="mdi mdi-phone-outline"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">No. Telepon</div>
                            <div class="detail-value">{{ $user->phone ?? '-' }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="mdi mdi-card-account-details-outline"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">NIK</div>
                            <div class="detail-value">{{ $user->nik ?? '-' }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="mdi mdi-shield-account-outline"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Role</div>
                            <div class="detail-value">
                                <span class="badge bg-{{ $user->role == 'admin' ? 'primary' : 'success' }} px-3 py-2">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="mdi mdi-map-marker-outline"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Alamat</div>
                            <div class="detail-value">{{ $user->address ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Profile Card Styling */
.profile-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 20px !important;
    overflow: hidden;
    position: relative;
}

.profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.profile-card .card-body {
    position: relative;
    z-index: 2;
}

.avatar-container {
    margin-right: 1rem;
}

.avatar-img {
    width: 100px;
    height: 100px;
    border: 4px solid rgba(255, 255, 255, 0.3);
    transition: transform 0.3s ease;
    object-fit: cover;
}

.avatar-img:hover {
    transform: scale(1.05);
}

.profile-name {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.profile-subtitle {
    font-size: 0.9rem;
    opacity: 0.8;
    font-weight: 500;
}

.info-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
}

.info-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    backdrop-filter: blur(10px);
}

.info-icon i {
    font-size: 1.2rem;
    color: white;
}

.info-label {
    font-size: 0.8rem;
    opacity: 0.8;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.info-value {
    font-size: 0.95rem;
    font-weight: 600;
}

/* Detail Card */
.detail-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.detail-item {
    background: #f8f9ff;
    border-radius: 12px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(102, 126, 234, 0.1);
    height: 100%;
}

.detail-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}

.detail-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    background: rgba(102, 126, 234, 0.1);
}

.detail-icon i {
    font-size: 1.5rem;
    color: #667eea;
}

.detail-label {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.detail-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: #343a40;
}

.btn-elegant {
    border-radius: 10px;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-elegant:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Responsive */
@media (max-width: 768px) {
    .profile-card .row {
        text-align: center;
    }
    
    .avatar-container {
        margin-bottom: 1rem;
    }
    
    .info-item {
        justify-content: center;
        text-align: center;
    }
    
    .detail-item {
        text-align: center;
        flex-direction: column;
    }
    
    .detail-icon {
        margin-right: 0;
        margin-bottom: 1rem;
    }
}
</style>
@endsection