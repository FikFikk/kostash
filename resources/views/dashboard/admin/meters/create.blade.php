@extends('admin.dashboard.layouts.app')

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
                    <label for="room_id" class="form-label">Kamar</label>
                    <select name="room_id" id="room_id" class="form-select" onchange="updateDefaultMeter(this.value)">
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                {{ $room->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="period" class="form-label">Periode</label>
                    <input type="month" class="form-control" name="period" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Air (m³)</label>
                        <div class="row">
                            <div class="col">
                                <input type="number" id="water_meter_start" name="water_meter_start" placeholder="Isi meter air awal" class="form-control" value="{{ old('water_meter_start') }}" required>
                            </div>
                            <div class="col">
                                <input type="number" name="water_meter_end" class="form-control" placeholder="Isi meter air akhir" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Listrik (kWh)</label>
                        <div class="row">
                            <div class="col">
                                <input type="number" id="electric_meter_start" name="electric_meter_start" placeholder="Isi meter listrik awal" class="form-control" value="{{ old('electric_meter_start') }}" required>
                            </div>
                            <div class="col">
                                <input type="number" name="electric_meter_end" class="form-control" placeholder="Isi meter listrik akhir" required>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
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
    document.addEventListener("DOMContentLoaded", function () {
        const selectedRoomId = document.getElementById('room_id').value;
        if (selectedRoomId) {
            updateDefaultMeter(selectedRoomId);
        }
    });
</script>


@endsection
