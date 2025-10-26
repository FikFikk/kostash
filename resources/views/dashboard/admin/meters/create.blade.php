@extends('dashboard.admin.layouts.app')

@section('title', 'Input Meter')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Input Meteran Baru</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('dashboard.meter.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="room_id" class="form-label">Kamar <span class="text-danger">*</span></label>
                        <select name="room_id" id="room_id" class="form-select" onchange="updateDefaultMeter(this.value)"
                            required>
                            <option value="">-- Pilih Kamar --</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Pilih kamar yang ingin diinputkan tagihan meteran.</small>
                    </div>

                    <div class="mb-3">
                        <label for="period" class="form-label">Periode <span class="text-danger">*</span></label>
                        <input type="month" class="form-control" name="period" required>
                        <small class="form-text text-muted">Pilih bulan dan tahun pembacaan meteran.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Air (m³) <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" id="water_meter_start" name="water_meter_start"
                                        placeholder="Meter air awal (angka di meteran sebelum bulan ini)"
                                        class="form-control bg-info-subtle border-info"
                                        value="{{ old('water_meter_start') }}" required>
                                    <small class="form-text text-info">Otomatis dari bulan lalu.</small>
                                </div>
                                <div class="col">
                                    <input type="number" name="water_meter_end" class="form-control"
                                        placeholder="Meter air akhir (angka di meteran setelah bulan ini)" required>
                                    <small class="form-text text-muted">Catat angka terbaru.</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Listrik (kWh) <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" id="electric_meter_start" name="electric_meter_start"
                                        placeholder="Meter listrik awal (angka di meteran sebelum bulan ini)"
                                        class="form-control bg-info-subtle border-info"
                                        value="{{ old('electric_meter_start') }}" required>
                                    <small class="form-text text-info">Otomatis dari bulan lalu.</small>
                                </div>
                                <div class="col">
                                    <input type="number" name="electric_meter_end" class="form-control"
                                        placeholder="Meter listrik akhir (angka di meteran setelah bulan ini)" required>
                                    <small class="form-text text-muted">Catat angka terbaru.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    {{-- <div class="mt-3">
                        <small class="text-muted">Semua kolom bertanda <span class="text-danger">*</span> wajib diisi.
                            Pastikan data yang diinput benar agar tagihan sesuai.</small>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        const defaultValues = @json($defaultStartValues);

        function updateDefaultMeter(roomId) {
            const values = defaultValues[roomId];
            if (values) {
                document.getElementById('water_meter_start').value = values.water_meter_start;
                document.getElementById('electric_meter_start').value = values.electric_meter_start;
            } else {
                document.getElementById('water_meter_start').value = 0;
                document.getElementById('electric_meter_start').value = 0;
            }
        }

        // Optional: panggil saat halaman dimuat jika sudah ada old('room_id')
        document.addEventListener("DOMContentLoaded", function() {
            const selectedRoomId = document.getElementById('room_id').value;
            if (selectedRoomId) {
                updateDefaultMeter(selectedRoomId);
            }
        });
    </script>


@endsection
