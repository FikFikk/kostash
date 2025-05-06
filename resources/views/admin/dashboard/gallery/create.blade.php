@extends('admin.dashboard.layouts.app')

@section('title', 'Create')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Upload Gambar Baru</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Nama Pengunggah</label>
                    <input type="text" name="uploader_name" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label>Kategori (pisahkan dengan koma)</label>
                    <input type="text" name="categories" class="form-control" placeholder="Contoh: interior,eksterior">
                </div>
                <div class="mb-3">
                    <label>Gambar</label>
                    <input type="file" name="filename" class="form-control" accept="image/*" required>
                </div>
                <a href="{{ route('gallery.index') }}" class="btn btn-outline-primary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>
@endsection
