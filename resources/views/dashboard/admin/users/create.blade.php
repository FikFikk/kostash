@extends('dashboard.admin.layouts.app')

@section('title', 'Create New User')

@push('styles')
{{-- Custom styles for a modern form UI --}}
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
    .image-preview-wrapper {
        position: relative;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background-color: var(--bs-tertiary-bg);
        border: 3px dashed var(--bs-border-color-translucent);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bs-secondary-color);
        transition: background-color 0.3s ease;
        margin: 0 auto 1rem auto;
        cursor: pointer;
    }
    .image-preview-wrapper:hover {
        background-color: var(--bs-light-bg-subtle);
        border-color: var(--bs-primary);
    }
    .image-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
    .image-preview-placeholder {
        text-align: center;
    }
    .image-preview-placeholder i {
        font-size: 2.5rem;
    }
    .form-control, .form-select {
        background-color: var(--bs-tertiary-bg);
        border: 1px solid var(--bs-border-color-translucent);
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
                    <h1 class="h3 fw-bold text-gradient mb-1"><i class="ri-user-add-line me-2"></i>Create New User</h1>
                    <p class="text-muted mb-0">Fill in the form below to create a new user account.</p>
                </div>
                 <a href="{{ route('dashboard.user.index') }}" class="btn btn-outline-secondary btn-sm mt-3 mt-lg-0">
                    <i class="ri-arrow-left-line me-1"></i> Back to User List
                </a>
            </div>
        </div>
    </div>

    <!-- Create User Form -->
    <form action="{{ route('dashboard.user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card content-card">
                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Left Column: Avatar and Account Type -->
                            <div class="col-lg-4 border-end-lg">
                                <h5 class="mb-3">User Profile</h5>
                                <div class="text-center mb-3">
                                    <label for="photo" class="image-preview-wrapper" id="image-upload-area">
                                        <div class="image-preview-placeholder" id="image-placeholder">
                                            <i class="ri-camera-line"></i>
                                            <p class="mb-0 small mt-1">Upload Photo</p>
                                        </div>
                                        <img src="" alt="Image Preview" class="image-preview" id="image-preview" style="display: none;">
                                    </label>
                                    <input type="file" name="photo" id="photo" class="d-none" accept="image/*">
                                    <p class="text-muted small mt-2">Recommended size: 300x300px</p>
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" id="role" class="form-select">
                                        <option value="tenants">Tenants</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="" class="form-select">
                                        <option value="aktif">Aktif</option>
                                        <option value="tidak_aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column: User Details -->
                            <div class="col-lg-8">
                                <h5 class="mb-3">Account & Personal Details</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                                    </div>
                                     <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm password" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter phone number">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" name="nik" id="nik" class="form-control" placeholder="Enter NIK">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea name="address" id="address" class="form-control" rows="2" placeholder="Enter full address"></textarea>
                                    </div>
                                </div>

                                <h5 class="mb-3 mt-2">Tenancy Details (Optional)</h5>
                                 <div class="row">
                                     <div class="col-md-6 mb-3">
                                        <label for="room_id" class="form-label">Assign to Room</label>
                                        <select name="room_id" id="room_id" class="form-select">
                                            <option value="">-- No Room --</option>
                                            @foreach($rooms as $room)
                                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="date_entry" class="form-label">Entry Date</label>
                                        <input type="date" name="date_entry" id="date_entry" class="form-control">
                                    </div>
                                     <div class="col-12 mb-3">
                                        <label for="catatan" class="form-label">Notes</label>
                                        <textarea name="catatan" id="catatan" class="form-control" rows="2" placeholder="Optional notes about the user"></textarea>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                     <div class="card-footer bg-transparent text-end p-3">
                        <a href="{{ route('dashboard.user.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview script
    const fileInput = document.getElementById('photo');
    const imagePreview = document.getElementById('image-preview');
    const imagePlaceholder = document.getElementById('image-placeholder');
    const imageUploadArea = document.getElementById('image-upload-area');

    // Trigger file input when the preview area is clicked
    imageUploadArea.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            imagePlaceholder.style.display = 'none';
            imagePreview.style.display = 'block';

            reader.addEventListener('load', function() {
                imagePreview.setAttribute('src', this.result);
            });
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
