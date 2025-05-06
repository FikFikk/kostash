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
                    <label>Kategori</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="preset_categories[]" value="room" id="catRoom">
                        <label class="form-check-label" for="catRoom">Kamar</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="preset_categories[]" value="facility" id="catFacility">
                        <label class="form-check-label" for="catFacility">Fasilitas</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="preset_categories[]" value="surroundings" id="catDurroundings">
                        <label class="form-check-label" for="catSurroundings">Lingkungan Sekitar</label>
                    </div>
                    <label for="customCategory">Kategori Lain (opsional)</label>
                    <input type="text" name="custom_categories" class="form-control" placeholder="Contoh: halaman belakang, dapur umum">
                    <small class="text-muted">Pisahkan dengan koma jika lebih dari satu.</small>
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
