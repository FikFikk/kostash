@extends('admin.dashboard.layouts.app')

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
                    <label for="room_id" class="form-label">Kamar</label>
                    <select name="room_id" class="form-select" required readonly>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ $room->id == $meter->room_id ? 'selected' : '' }}>{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="period" class="form-label">Periode</label>
                    <input type="month" class="form-control" name="period" value="{{ \Carbon\Carbon::parse($meter->period)->format('Y-m') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Air (m³)</label>
                        <div class="row">
                            <div class="col">
                                <input type="number" name="water_meter_start" class="form-control" value="{{ $meter->water_meter_start }}" required>
                            </div>
                            <div class="col">
                                <input type="number" name="water_meter_end" class="form-control" value="{{ $meter->water_meter_end }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Listrik (kWh)</label>
                        <div class="row">
                            <div class="col">
                                <input type="number" name="electric_meter_start" class="form-control" value="{{ $meter->electric_meter_start }}" required>
                            </div>
                            <div class="col">
                                <input type="number" name="electric_meter_end" class="form-control" value="{{ $meter->electric_meter_end }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Perbarui</button>
            </form>
        </div>
    </div>
</div>
@endsection
