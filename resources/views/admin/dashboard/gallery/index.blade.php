@extends('admin.dashboard.layouts.app')

@section('title', 'Gallery')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h4 class="card-title mb-0 flex-grow-1">Gallery</h4>
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard.gallery.create') }}" class="btn btn-primary btn-label">
                    <i class="ri-add-line label-icon align-middle fs-16 me-2"></i> Add Image
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($galleries as $gallery)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $gallery->filename) }}" class="card-img-top" alt="{{ $gallery->title }}" style="height: 200px; object-fit: cover; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal{{ $gallery->id }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $gallery->title }}</h5>
                                <p class="card-text"><small class="text-muted">By: {{ $gallery->uploader_name ?? '-' }}</small></p>
                                <div class="mb-2">
                                    @foreach($gallery->categories ?? [] as $category)
                                        <span class="badge bg-info">{{ $category }}</span>
                                    @endforeach
                                </div>
                                <a href="{{ route('dashboard.gallery.edit', $gallery->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('dashboard.gallery.destroy', $gallery->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus gambar ini?')" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="imageModal{{ $gallery->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $gallery->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <img src="{{ asset('storage/' . $gallery->filename) }}" class="img-fluid rounded">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <p>Tidak ada gambar.</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $galleries->links('admin.dashboard.layouts.pagination') }}
            </div>
        </div>
    </div>
</div>
@endsection
