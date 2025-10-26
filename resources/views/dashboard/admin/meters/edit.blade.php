@extends('dashboard.admin.layouts.app')

@section('title', 'Edit Meter')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Edit Data Meteran</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('dashboard.meter.update', $meter->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="room_id" value="{{ $meter->room_id }}">

                    <div class="mb-3">
                        <label for="room_id" class="form-label">Kamar <span class="text-danger">*</span></label>
                        <select name="room_id" class="form-select" required readonly tabindex="-1" aria-disabled="true"
                            disabled>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ $room->id == $meter->room_id ? 'selected' : '' }}>
                                    {{ $room->name }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Kamar tidak dapat diubah saat edit. Jika ingin pindah kamar,
                            hapus dan buat data baru.</small>
                    </div>

                    <div class="mb-3">
                        <label for="period" class="form-label">Periode <span class="text-danger">*</span></label>
                        <input type="month" class="form-control" name="period"
                            value="{{ \Carbon\Carbon::parse($meter->period)->format('Y-m') }}" required>
                        <small class="form-text text-muted">Pilih bulan dan tahun pembacaan meteran (misal: 2025-10 untuk
                            Oktober 2025).</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Air (m³) <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" name="water_meter_start"
                                        class="form-control bg-info-subtle border-info"
                                        value="{{ $meter->water_meter_start }}" required
                                        placeholder="Meter air awal (angka di meteran sebelum bulan ini)">
                                    <small class="form-text text-info">Otomatis dari bulan lalu.</small>
                                </div>
                                <div class="col">
                                    <input type="number" name="water_meter_end" class="form-control"
                                        value="{{ $meter->water_meter_end }}" required
                                        placeholder="Meter air akhir (angka di meteran setelah bulan ini)">
                                    <small class="form-text text-muted">Catat angka terbaru.</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Listrik (kWh) <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" name="electric_meter_start"
                                        class="form-control bg-info-subtle border-info"
                                        value="{{ $meter->electric_meter_start }}" required
                                        placeholder="Meter listrik awal (angka di meteran sebelum bulan ini)">
                                    <small class="form-text text-info">Otomatis dari bulan lalu.</small>
                                </div>
                                <div class="col">
                                    <input type="number" name="electric_meter_end" class="form-control"
                                        value="{{ $meter->electric_meter_end }}" required
                                        placeholder="Meter listrik akhir (angka di meteran setelah bulan ini)">
                                    <small class="form-text text-muted">Catat angka terbaru.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Perbarui</button>
                    {{-- <div class="mt-3">
                        <small class="text-muted">Semua kolom bertanda <span class="text-danger">*</span> wajib diisi.
                            Pastikan data yang diinput benar agar tagihan sesuai.</small>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
@endsection
