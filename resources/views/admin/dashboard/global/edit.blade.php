@extends('admin.dashboard.layouts.app')

@section('title', 'Global')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-success">
                    <h4 class="mb-0 text-white"><i class="ri-edit-line me-2"></i>Edit Global Setting</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('global.update', $global->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga Kos Per-Bulan (Rp)</label>
                            <input type="number" name="monthly_room_price" class="form-control"
                                value="{{ old('monthly_room_price', $global->monthly_room_price) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga Air Per-Kubik (Rp)</label>
                            <input type="number" name="water_price" class="form-control"
                                value="{{ old('water_price', $global->water_price) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga Listrik Per-KwH (Rp)</label>
                            <input type="number" name="electric_price" class="form-control"
                                value="{{ old('electric_price', $global->electric_price) }}" required>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('global.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-success">
                                <i class="ri-save-line me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
