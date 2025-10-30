@extends('dashboard.admin.layouts.app')

@section('title', 'Edit Gambar')

@push('styles')
    <style>
        /* Dark Mode Support & Modern Design */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --bg-card: #ffffff;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --text-muted: #adb5bd;
            --border-color: #dee2e6;
            --input-bg: #ffffff;
            --input-border: #ced4da;
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        [data-bs-theme="dark"],
        .dark-mode {
            --bg-primary: #1a1d23;
            --bg-secondary: #212529;
            --bg-card: #2c3034;
            --text-primary: #f8f9fa;
            --text-secondary: #adb5bd;
            --text-muted: #6c757d;
            --border-color: #495057;
            --input-bg: #212529;
            --input-border: #495057;
            --shadow-sm: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.5);
            --shadow-md: 0 0.5rem 1rem rgba(0, 0, 0, 0.3);
        }

        /* Card Styling */
        .upload-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .upload-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border: none;
        }

        .upload-card-body {
            padding: 2rem;
            background: var(--bg-card);
        }

        /* Form Section */
        .form-section {
            background: var(--bg-secondary);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .section-title {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
            opacity: 0.7;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-primary);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            background: var(--input-bg);
            border-color: #667eea;
            color: var(--text-primary);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-label {
            color: var(--text-primary);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* Checkbox & Radio Modern Style */
        .option-card {
            position: relative;
            background: var(--bg-card);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .option-card:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .option-card input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .option-card input:checked~.option-content {
            color: #667eea;
        }

        .option-card input:checked+.option-card {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        }

        .option-checkbox:checked+.option-card {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        }

        .option-content {
            color: var(--text-primary);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .option-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            opacity: 0.8;
        }

        /* Category Pills */
        .category-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: 25px;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0.25rem;
        }

        .category-pill:hover {
            border-color: #667eea;
            transform: translateY(-2px);
        }

        .category-pill input {
            display: none;
        }

        .category-pill input:checked+span {
            color: #667eea;
        }

        .category-pill input:checked~.category-pill,
        .category-pill.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
            color: white;
        }

        /* FilePond Custom Styling for Dark Mode */
        .filepond--root {
            font-family: inherit;
            border-radius: 10px;
            overflow: hidden;
        }

        .filepond--panel-root {
            background: var(--bg-secondary);
            border: 2px dashed var(--border-color);
        }

        .filepond--drop-label {
            color: var(--text-secondary);
            background: var(--bg-secondary);
        }

        .dark-mode .filepond--drop-label,
        [data-bs-theme="dark"] .filepond--drop-label {
            color: var(--text-secondary);
        }

        .filepond--label-action {
            color: #667eea;
            text-decoration: underline;
        }

        .filepond--file {
            color: var(--text-primary);
        }

        /* Upload Area */
        .upload-area {
            background: var(--bg-secondary);
            border: 3px dashed var(--border-color);
            border-radius: 12px;
            padding: 3rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .upload-area:hover {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        }

        .upload-area.dragging {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        }

        .upload-icon {
            font-size: 4rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        /* Buttons */
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .btn-outline-gradient {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-gradient:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .upload-card-body {
                padding: 1rem;
            }

            .form-section {
                padding: 1rem;
            }

            .option-card {
                min-height: 60px;
                padding: 0.75rem;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="upload-card fade-in">
                    <div class="upload-card-header">
                        <h4 class="mb-0 d-flex align-items-center">
                            <i class="fas fa-edit me-3"></i>
                            Edit Gambar
                        </h4>
                    </div>

                    <div class="upload-card-body">
                        <form action="{{ route('dashboard.gallery.update', $gallery->id) }}" method="POST"
                            enctype="multipart/form-data" id="uploadForm">
                            @csrf
                            @method('PUT')

                            <!-- Section 1: Informasi Dasar -->
                            <div class="form-section">
                                <h6 class="section-title">
                                    <i class="fas fa-info-circle"></i>
                                    Informasi Dasar
                                </h6>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Judul <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="title" class="form-control"
                                        placeholder="Masukkan judul gambar" value="{{ old('title', $gallery->title) }}"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Pengunggah</label>
                                    {{-- Show uploader from database. Editing should not change the uploader. --}}
                                    <input type="text" class="form-control" value="{{ $gallery->uploader_name ?? '-' }}"
                                        disabled>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Tambahkan deskripsi (opsional)">{{ old('description', $gallery->description) }}</textarea>
                                </div>
                            </div>

                            <!-- Section 2: Tipe Tampilan -->
                            <div class="form-section">
                                <h6 class="section-title">
                                    <i class="fas fa-desktop"></i>
                                    Tipe Tampilan
                                </h6>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <label>
                                            <input type="checkbox" name="is_gallery" value="1" class="option-checkbox"
                                                {{ $gallery->is_gallery ? 'checked' : '' }}>
                                            <div class="option-card">
                                                <div class="option-content">
                                                    <i class="fas fa-th option-icon"></i>
                                                    <div>Gallery</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="col-6">
                                        <label>
                                            <input type="checkbox" name="is_carousel" value="1" class="option-checkbox"
                                                {{ $gallery->is_carousel ? 'checked' : '' }}>
                                            <div class="option-card">
                                                <div class="option-content">
                                                    <i class="fas fa-images option-icon"></i>
                                                    <div>Carousel</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: Kategori -->
                            <div class="form-section">
                                <h6 class="section-title">
                                    <i class="fas fa-tags"></i>
                                    Kategori
                                </h6>

                                <div class="d-flex flex-wrap mb-3">
                                    <label
                                        class="category-pill {{ in_array('room', $gallery->categories ?? []) ? 'active' : '' }}">
                                        <input type="checkbox" name="preset_categories[]" value="room"
                                            {{ in_array('room', $gallery->categories ?? []) ? 'checked' : '' }}>
                                        <span>
                                            <i class="fas fa-bed me-2"></i>Kamar
                                        </span>
                                    </label>

                                    <label
                                        class="category-pill {{ in_array('facility', $gallery->categories ?? []) ? 'active' : '' }}">
                                        <input type="checkbox" name="preset_categories[]" value="facility"
                                            {{ in_array('facility', $gallery->categories ?? []) ? 'checked' : '' }}>
                                        <span>
                                            <i class="fas fa-swimming-pool me-2"></i>Fasilitas
                                        </span>
                                    </label>

                                    <label
                                        class="category-pill {{ in_array('surroundings', $gallery->categories ?? []) ? 'active' : '' }}">
                                        <input type="checkbox" name="preset_categories[]" value="surroundings"
                                            {{ in_array('surroundings', $gallery->categories ?? []) ? 'checked' : '' }}>
                                        <span>
                                            <i class="fas fa-tree me-2"></i>Lingkungan Sekitar
                                        </span>
                                    </label>
                                </div>

                                <div>
                                    <label class="form-label">Kategori Lain (opsional)</label>
                                    <input type="text" name="custom_categories" class="form-control"
                                        placeholder="Contoh: halaman belakang, dapur umum"
                                        value="{{ old('custom_categories', implode(',', array_diff($gallery->categories ?? [], ['room', 'facility', 'surroundings']))) }}">
                                    <small class="text-muted">Pisahkan dengan koma jika lebih dari satu.</small>
                                </div>
                            </div>

                            <!-- Section 4: Gambar Sekarang -->
                            <div class="form-section">
                                <h6 class="section-title">
                                    <i class="fas fa-image"></i>
                                    Gambar Sekarang
                                </h6>

                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $gallery->filename) }}" alt="Current Image"
                                        class="img-fluid rounded" style="max-height: 300px;">
                                </div>
                            </div>

                            <!-- Section 5: Ganti Gambar -->
                            <div class="form-section">
                                <h6 class="section-title">
                                    <i class="fas fa-upload"></i>
                                    Ganti Gambar (opsional)
                                </h6>

                                <div class="upload-area" id="uploadArea">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <h5 class="mt-3 mb-2" style="color: var(--text-primary);">
                                        Drag & Drop gambar baru atau Browse
                                    </h5>
                                    <p class="text-muted mb-0">
                                        Maksimal 5MB (JPG, PNG, GIF, WEBP)
                                    </p>
                                </div>
                                <input type="file" name="filename" id="fileInput" accept="image/*"
                                    style="display: none;">

                                <!-- Preview Area -->
                                <div id="previewArea" style="display: none;" class="mt-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <img id="previewImage" src="" alt="Preview"
                                                class="img-fluid rounded" style="max-height: 200px;">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="ps-3">
                                                <h6 style="color: var(--text-primary);">File Information</h6>
                                                <p class="mb-1"><small class="text-muted">Name:</small> <span
                                                        id="fileName" style="color: var(--text-primary);"></span></p>
                                                <p class="mb-1"><small class="text-muted">Size:</small> <span
                                                        id="fileSize" style="color: var(--text-primary);"></span></p>
                                                <p class="mb-2"><small class="text-muted">Type:</small> <span
                                                        id="fileType" style="color: var(--text-primary);"></span></p>
                                                <button type="button" class="btn btn-sm btn-danger" id="removeBtn">
                                                    <i class="fas fa-trash me-1"></i> Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('dashboard.gallery.index') }}" class="btn btn-outline-gradient">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-gradient" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Update Gambar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // File Upload Handler
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('fileInput');
            const previewArea = document.getElementById('previewArea');
            const previewImage = document.getElementById('previewImage');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const fileType = document.getElementById('fileType');
            const removeBtn = document.getElementById('removeBtn');

            // Click to upload
            uploadArea.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                fileInput.click();
            });

            // Handle file selection
            fileInput.addEventListener('change', function(e) {
                handleFile();
            });

            // Drag and Drop Events
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadArea.classList.add('dragging');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadArea.classList.remove('dragging');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadArea.classList.remove('dragging');

                const files = e.dataTransfer.files;
                if (files && files.length > 0) {
                    // Check if it's an image file
                    if (files[0].type.startsWith('image/')) {
                        // Manually set files to input
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(files[0]);
                        fileInput.files = dataTransfer.files;
                        handleFile();
                    } else {
                        alert('Please upload an image file only!');
                    }
                }
            });

            // Remove button click handler
            removeBtn.addEventListener('click', function() {
                removeImage();
            });

            function handleFile() {
                const file = fileInput.files[0];
                if (file && file.type.startsWith('image/')) {
                    // Check file size (5MB limit)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File terlalu besar! Maksimal 5MB');
                        fileInput.value = '';
                        return;
                    }

                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        fileName.textContent = file.name;
                        fileSize.textContent = formatFileSize(file.size);
                        fileType.textContent = file.type;

                        uploadArea.style.display = 'none';
                        previewArea.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            }

            function removeImage() {
                fileInput.value = '';
                previewArea.style.display = 'none';
                uploadArea.style.display = 'block';
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
            }

            // Category Pills Active State
            document.querySelectorAll('.category-pill input').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        this.closest('.category-pill').classList.add('active');
                    } else {
                        this.closest('.category-pill').classList.remove('active');
                    }
                });
            });

            // Form Validation
            document.getElementById('uploadForm').addEventListener('submit', function(e) {
                // Disable submit button
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...';
            });

            // Always use light theme
            // Dark mode removed as colors were not matching
        });
    </script>
@endpush
