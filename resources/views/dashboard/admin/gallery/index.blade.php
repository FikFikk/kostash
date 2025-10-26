@extends('dashboard.admin.layouts.app')

@section('title', 'Gallery')

@push('styles')
    <style>
        .gallery-page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .gallery-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease-in-out;
            position: relative;
        }

        .gallery-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .gallery-image-wrapper {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        .gallery-card:hover .gallery-image {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 50%);
            display: flex;
            align-items: flex-end;
            padding: 1rem;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .gallery-card:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-actions {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .empty-gallery {
            text-align: center;
            padding: 4rem;
            border: 2px dashed var(--bs-border-color-translucent);
            border-radius: 1rem;
        }

        .empty-gallery i {
            font-size: 3rem;
            color: var(--bs-primary);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="gallery-page-header text-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h2 fw-bold mb-1 text-white"><i class="ri-gallery-line me-2"></i>Gallery Management</h1>
                    <p class="mb-0 opacity-75">Add, edit, or delete images shown on the public page.</p>
                </div>
                <a href="{{ route('dashboard.gallery.create') }}" class="btn btn-light">
                    <i class="ri-add-line me-1"></i> Add New Image
                </a>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="row">
            @forelse($galleries as $gallery)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card gallery-card">
                        <div class="gallery-image-wrapper">
                            <img src="{{ asset('storage/' . $gallery->filename) }}" class="gallery-image"
                                alt="{{ $gallery->title }}" data-bs-toggle="modal"
                                data-bs-target="#imageModal{{ $gallery->id }}" style="cursor: pointer;">
                            <div class="gallery-overlay">
                                <h5 class="card-title text-white mb-0 text-truncate">{{ $gallery->title }}</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                @if (!empty($gallery->is_carousel))
                                    <span class="badge bg-info text-white">Carousel</span>
                                @endif
                                @if (!empty($gallery->is_gallery))
                                    <span class="badge bg-success">Gallery</span>
                                @endif
                            </div>
                            <div class="mb-2">
                                @foreach ($gallery->categories ?? [] as $category)
                                    <span class="badge bg-primary-subtle text-primary">{{ $category }}</span>
                                @endforeach
                            </div>
                            <p class="card-text mb-0"><small class="text-muted">Uploaded by:
                                    {{ $gallery->uploader_name ?? '-' }}</small></p>
                        </div>
                        <div class="gallery-actions">
                            <a href="{{ route('dashboard.gallery.edit', $gallery->id) }}" class="btn btn-sm btn-light">
                                <i class="ri-pencil-line"></i>
                            </a>
                            <form action="{{ route('dashboard.gallery.destroy', $gallery->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this image?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="imageModal{{ $gallery->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content" style="background: transparent; border: none;">
                                <div class="modal-body p-0">
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"
                                        style="position: absolute; top: 1rem; right: 1rem; z-index: 10;"></button>
                                    <img src="{{ asset('storage/' . $gallery->filename) }}" class="img-fluid rounded-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-gallery">
                        <i class="ri-image-add-line mb-3"></i>
                        <h4 class="mb-1">The Gallery is Empty</h4>
                        <p class="text-muted">Start by adding your first image.</p>
                        <a href="{{ route('dashboard.gallery.create') }}" class="btn btn-primary mt-2">
                            <i class="ri-add-line me-1"></i> Add First Image
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($galleries->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $galleries->links('dashboard.admin.layouts.pagination') }}
            </div>
        @endif
    </div>
@endsection
