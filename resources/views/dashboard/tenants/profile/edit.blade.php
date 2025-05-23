@extends('dashboard.tenants.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Edit Profil</h3>
        <a href="{{ route('tenant.profile.index') }}" class="btn btn-outline-secondary btn-elegant">
            <i class="mdi mdi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="mdi mdi-alert-circle-outline me-2"></i>
            <strong>Ada kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card Profile Edit dengan Desain Elegan -->
    <div class="card shadow-lg border-0 mb-4 edit-card">
        <div class="card-header bg-transparent border-0 pb-0">
            <h5 class="card-title mb-0 fw-bold">
                <i class="mdi mdi-account-edit-outline me-2"></i>
                Edit Informasi Profil
            </h5>
        </div>
        <div class="card-body pt-3">
            <form action="{{ route('tenant.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')

                <!-- Photo Upload Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="photo-upload-section text-center">
                            <div class="current-photo mb-3">
                                @if($user->photo)
                                    <img src="{{ asset('storage/uploads/profile/' . $user->photo) }}" 
                                         alt="Current Photo" 
                                         id="currentPhoto"
                                         class="profile-photo rounded-circle shadow">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=667eea&color=fff&size=150&font-size=0.4"
                                         alt="Current Photo" 
                                         id="currentPhoto"
                                         class="profile-photo rounded-circle shadow">
                                @endif
                            </div>
                            
                            <div class="photo-upload-btn">
                                <label for="photo" class="btn btn-outline-primary btn-elegant">
                                    <i class="mdi mdi-camera-outline me-1"></i>
                                    Ganti Foto
                                </label>
                                <input type="file" id="photo" name="photo" class="d-none" accept="image/*">
                            </div>
                            <small class="text-muted d-block mt-2">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <!-- Nama Lengkap -->
                    <div class="col-md-6">
                        <div class="form-group-elegant">
                            <label for="name" class="form-label">
                                <i class="mdi mdi-account-outline me-1"></i>
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-elegant @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="form-group-elegant">
                            <label for="email" class="form-label">
                                <i class="mdi mdi-email-outline me-1"></i>
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control form-control-elegant @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- No Telepon -->
                    <div class="col-md-6">
                        <div class="form-group-elegant">
                            <label for="phone" class="form-label">
                                <i class="mdi mdi-phone-outline me-1"></i>
                                No. Telepon
                            </label>
                            <input type="text" 
                                   class="form-control form-control-elegant @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- NIK -->
                    <div class="col-md-6">
                        <div class="form-group-elegant">
                            <label for="nik" class="form-label">
                                <i class="mdi mdi-card-account-details-outline me-1"></i>
                                NIK
                            </label>
                            <input type="text" 
                                   class="form-control form-control-elegant @error('nik') is-invalid @enderror" 
                                   id="nik" 
                                   name="nik" 
                                   value="{{ old('nik', $user->nik) }}">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="col-12">
                        <div class="form-group-elegant">
                            <label for="address" class="form-label">
                                <i class="mdi mdi-map-marker-outline me-1"></i>
                                Alamat
                            </label>
                            <textarea class="form-control form-control-elegant @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="3">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Fields yang disabled -->
                    <div class="col-md-6">
                        <div class="form-group-elegant">
                            <label for="date_entry" class="form-label">
                                <i class="mdi mdi-calendar-start me-1"></i>
                                Tanggal Masuk
                            </label>
                            <input type="text" 
                                   class="form-control form-control-elegant" 
                                   value="{{ $user->date_entry ? \Carbon\Carbon::parse($user->date_entry)->translatedFormat('d F Y') : '-' }}" 
                                   disabled>
                            <small class="text-muted">Field ini tidak dapat diubah</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group-elegant">
                            <label for="role" class="form-label">
                                <i class="mdi mdi-shield-account-outline me-1"></i>
                                Role
                            </label>
                            <input type="text" 
                                   class="form-control form-control-elegant" 
                                   value="{{ ucfirst($user->role) }}" 
                                   disabled>
                            <small class="text-muted">Field ini tidak dapat diubah</small>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary btn-elegant btn-lg" id="submitBtn">
                        <i class="mdi mdi-content-save-outline me-1" id="submitIcon"></i>
                        <span id="submitText">Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.edit-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.profile-photo {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 4px solid rgba(102, 126, 234, 0.2);
    transition: all 0.3s ease;
}

.profile-photo:hover {
    transform: scale(1.05);
    border-color: rgba(102, 126, 234, 0.5);
}

.photo-upload-section {
    background: linear-gradient(135deg, #f8f9ff 0%, #e3e8ff 100%);
    border-radius: 15px;
    padding: 2rem;
    border: 2px dashed rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.photo-upload-section:hover {
    border-color: rgba(102, 126, 234, 0.5);
    transform: translateY(-2px);
}

.form-group-elegant {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.form-label i {
    color: #667eea;
}

.form-control-elegant {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #f8f9ff;
}

.form-control-elegant:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    background: white;
    transform: translateY(-1px);
}

.form-control-elegant:disabled {
    background: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
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

.btn-lg.btn-elegant {
    padding: 1rem 2rem;
    font-size: 1.1rem;
}

.invalid-feedback {
    display: block;
    font-size: 0.875rem;
    color: #dc3545;
    margin-top: 0.25rem;
}

.is-invalid {
    border-color: #dc3545 !important;
}

.is-invalid:focus {
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15) !important;
}

/* Loading Animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.mdi-spin {
    animation: spin 1s linear infinite;
}

/* Responsive */
@media (max-width: 768px) {
    .photo-upload-section {
        padding: 1.5rem;
    }
    
    .profile-photo {
        width: 120px;
        height: 120px;
    }
    
    .btn-lg.btn-elegant {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview foto sebelum upload
    const photoInput = document.getElementById('photo');
    const currentPhoto = document.getElementById('currentPhoto');
    
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                currentPhoto.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Loading state untuk form submit
    const form = document.getElementById('profileForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitIcon = document.getElementById('submitIcon');
    const submitText = document.getElementById('submitText');

    form.addEventListener('submit', function(e) {
        // Ubah tampilan tombol menjadi loading
        submitBtn.disabled = true;
        submitBtn.classList.add('disabled');
        
        // Ubah icon menjadi loading spinner
        submitIcon.className = 'mdi mdi-loading mdi-spin me-1';
        submitText.textContent = 'Menyimpan...';
        
        // Optional: Tambahkan cursor loading pada body
        document.body.style.cursor = 'wait';
    });
});
</script>
@endsection