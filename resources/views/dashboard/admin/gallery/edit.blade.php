@extends('dashboard.admin.layouts.app')

@section('title', 'Update')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Gambar</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.gallery.update', $gallery->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" name="title" value="{{ old('title', $gallery->title) }}" class="form-control"
                            required>
                    </div>
                    <div class="mb-3">
                        <label>Nama Pengunggah</label>
                        {{-- Show current authenticated user name (or existing uploader as fallback). The server will set uploader_name to the authenticated user. --}}
                        <input type="text" class="form-control"
                            value="{{ auth()->user()->name ?? $gallery->uploader_name }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control">{{ old('description', $gallery->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label><br>
                        <!-- Preset categories checkbox -->
                        @foreach (['room', 'facility', 'surroundings'] as $presetCategory)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="preset_categories[]"
                                    value="{{ $presetCategory }}"
                                    {{ in_array($presetCategory, $gallery->categories) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ ucfirst($presetCategory) }}</label>
                            </div>
                        @endforeach

                        <!-- Manual input for additional categories -->
                        <input type="text" name="custom_categories"
                            value="{{ old('custom_categories', implode(',', array_diff($gallery->categories ?? [], ['interior', 'eksterior', 'surroundings']))) }}"
                            class="form-control mt-2" placeholder="Tambah kategori lain (pisahkan dengan koma)">
                    </div>
                    <div class="mb-3">
                        <label>Gambar Sekarang</label><br>
                        <img src="{{ asset('storage/' . $gallery->filename) }}" alt="" class="img-thumbnail"
                            width="200">
                    </div>
                    <div class="mb-3">
                        <label>Tipe Tampilan</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_gallery" value="1" id="isGallery"
                                {{ $gallery->is_gallery ? 'checked' : '' }}>
                            <label class="form-check-label" for="isGallery">Gallery</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_carousel" value="1"
                                id="isCarousel" {{ $gallery->is_carousel ? 'checked' : '' }}>
                            <label class="form-check-label" for="isCarousel">Carousel</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Ganti Gambar (opsional)</label>
                        <input type="file" name="filename" class="form-control" accept="image/*">
                    </div>
                    <a href="{{ route('dashboard.gallery.index') }}" class="btn btn-outline-primary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
