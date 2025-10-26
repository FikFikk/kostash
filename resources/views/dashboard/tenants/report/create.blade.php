@extends('dashboard.tenants.layouts.app')

@section('title', 'Buat Laporan Baru')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Formulir Laporan Kendala</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('tenant.report.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Laporan <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    name="title" id="title" placeholder="Contoh: Lampu kamar mandi mati"
                                    value="{{ old('title') }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="room_id" class="form-label">Kamar <span class="text-danger">*</span></label>
                                <select class="form-select @error('room_id') is-invalid @enderror" name="room_id">
                                    <option value="{{ $room->id }}" selected>{{ $room->name }}</option>
                                </select>
                                @error('room_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori Kendala <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror" name="category">
                                    <option value="" disabled selected>Pilih kategori...</option>
                                    @foreach ($categories as $key => $value)
                                        <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Lengkap <span
                                        class="text-danger">*</span></label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                    rows="4" placeholder="Jelaskan kendala Anda sedetail mungkin...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="priority" class="form-label">Tingkat Prioritas <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('priority') is-invalid @enderror" name="priority">
                                    @foreach ($priorities as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ old('priority', 'medium') == $key ? 'selected' : '' }}>{{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Pilih seberapa mendesak kendala ini perlu ditangani.</div>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="images" class="form-label">Bukti Foto/Video (Opsional)</label>
                                <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                                    name="images[]" multiple accept="image/*">
                                <div class="form-text">Anda bisa mengunggah lebih dari satu gambar (Maks. 5).</div>
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('tenant.report.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">Kirim Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
