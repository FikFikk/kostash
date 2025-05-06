@extends('admin.dashboard.layouts.app')

@section('title', 'Update')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Gambar</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" name="title" value="{{ old('title', $gallery->title) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Nama Pengunggah</label>
                    <input type="text" name="uploader_name" value="{{ old('uploader_name', $gallery->uploader_name) }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control">{{ old('description', $gallery->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Kategori (pisahkan dengan koma)</label>
                    <input type="text" name="categories" value="{{ implode(',', $gallery->categories ?? []) }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Gambar Sekarang</label><br>
                    <img src="{{ asset('storage/' . $gallery->filename) }}" alt="" class="img-thumbnail" width="200">
                </div>
                <div class="mb-3">
                    <label>Ganti Gambar (opsional)</label>
                    <input type="file" name="filename" class="form-control" accept="image/*">
                </div>
                <a href="{{ route('gallery.index') }}" class="btn btn-outline-primary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
