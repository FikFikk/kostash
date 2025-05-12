<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use App\Models\Room;
use App\Models\GlobalSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MeterController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('name')->get();
        $roomMeters = [];
    
        foreach ($rooms as $room) {
            $roomMeters[$room->id] = Meter::with('room')
                ->where('room_id', $room->id)
                ->orderByDesc('period')
                ->paginate(5, ['*'], 'page_' . $room->id); // penting: pagination key unik per kamar
        }
    
        return view('admin.dashboard.meters.index', compact('rooms', 'roomMeters'));
    }

    public function create()
    {
        $rooms = Room::orderBy('name')->get();

        $defaultStartValues = [];

        foreach ($rooms as $room) {
            $lastMeter = Meter::where('room_id', $room->id)
                ->orderByDesc('period')
                ->first();

            $defaultStartValues[$room->id] = [
                'water_meter_start' => $lastMeter?->water_meter_end ?? 0,
                'electric_meter_start' => $lastMeter?->electric_meter_end ?? 0,
            ];
        }
        return view('admin.dashboard.meters.create', compact('rooms', 'defaultStartValues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'period' => 'required|date',
            'water_meter_start' => 'required|integer',
            'water_meter_end' => 'required|integer|gte:water_meter_start',
            'electric_meter_start' => 'required|integer',
            'electric_meter_end' => 'required|integer|gte:electric_meter_start',
        ], [
            'water_meter_end.gte' => 'Meter air akhir harus lebih besar atau sama dengan meter awal.',
            'electric_meter_end.gte' => 'Meter listrik akhir harus lebih besar atau sama dengan meter awal.',
        ]);
        

        $global = GlobalSetting::first();

        $total_water = $request->water_meter_end - $request->water_meter_start;
        $total_electric = $request->electric_meter_end - $request->electric_meter_start;
        $total_bill = $global->monthly_room_price +
            ($total_water * $global->water_price) +
            ($total_electric * $global->electric_price);

        $period = $request->input('period') . '-07';

        Meter::create([
            'room_id' => $request->room_id,
            'water_meter_start' => $request->water_meter_start,
            'water_meter_end' => $request->water_meter_end,
            'electric_meter_start' => $request->electric_meter_start,
            'electric_meter_end' => $request->electric_meter_end,
            'total_water' => $total_water,
            'total_electric' => $total_electric,
            'total_bill' => $total_bill,
            'period' => $period,
        ]);

        return redirect()->route('dashboard.meter.index')->with('success', 'Meter added successfully.');
    }

    public function edit($id)
    {
        $meter = Meter::findOrFail($id);
        $rooms = Room::all();

        return view('admin.dashboard.meters.edit', compact('meter', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        $meter = Meter::findOrFail($id);

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'water_meter_start' => 'required|integer',
            'water_meter_end' => 'required|integer|gte:water_meter_start',
            'electric_meter_start' => 'required|integer',
            'electric_meter_end' => 'required|integer|gte:electric_meter_start',
            'period' => 'required|date',
        ]);

        $global = GlobalSetting::first();

        $total_water = $request->water_meter_end - $request->water_meter_start;
        $total_electric = $request->electric_meter_end - $request->electric_meter_start;
        $total_bill = $global->monthly_room_price +
            ($total_water * $global->water_price) +
            ($total_electric * $global->electric_price);

        $period = $request->input('period') . '-07';

        $meter->update([
            'room_id' => $request->room_id,
            'water_meter_start' => $request->water_meter_start,
            'water_meter_end' => $request->water_meter_end,
            'electric_meter_start' => $request->electric_meter_start,
            'electric_meter_end' => $request->electric_meter_end,
            'total_water' => $total_water,
            'total_electric' => $total_electric,
            'total_bill' => $total_bill,
            'period' => $period,
        ]);

        return redirect()->route('dashboard.meter.index')->with('success', 'Meter updated successfully.');
    }

    public function destroy(Meter $meter)
    {
        $meter->delete();
        return redirect()->route('dashboard.meter.index')->with('success', 'Meter deleted successfully.');
    }
}
