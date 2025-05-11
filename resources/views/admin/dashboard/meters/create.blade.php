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
                    <select name="room_id" class="form-select" required>
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
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
                                <input type="number" name="water_meter_start" class="form-control" placeholder="Awal" required>
                            </div>
                            <div class="col">
                                <input type="number" name="water_meter_end" class="form-control" placeholder="Akhir" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Listrik (kWh)</label>
                        <div class="row">
                            <div class="col">
                                <input type="number" name="electric_meter_start" class="form-control" placeholder="Awal" required>
                            </div>
                            <div class="col">
                                <input type="number" name="electric_meter_end" class="form-control" placeholder="Akhir" required>
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
