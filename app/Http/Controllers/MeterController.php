<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use App\Models\Room;
use App\Models\User;
use App\Models\GlobalSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                ->paginate(5, ['*'], 'page_' . $room->id);
        }

        return view('dashboard.admin.meters.index', compact('rooms', 'roomMeters'));
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

        return view('dashboard.admin.meters.create', compact('rooms', 'defaultStartValues'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateMeter($request);

        $period = $this->parsePeriod($validated['period']);

        $user = User::where('room_id', $validated['room_id'])
            ->where('role', 'tenants')
            ->first();

        $exists = Meter::where('room_id', $validated['room_id'])
            ->where('period', $period)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'period' => 'Data meter untuk kamar dan periode ini sudah ada.',
            ]);
        }

        $global = $this->getGlobalSettings();

        $billData = $this->calculateTotalBill(
            $validated['water_meter_start'],
            $validated['water_meter_end'],
            $validated['electric_meter_start'],
            $validated['electric_meter_end'],
            $global
        );

        Meter::create(array_merge($validated, $billData, ['period' => $period, 'user_id' => $user?->id]));

        return redirect()->route('dashboard.meter.index')->with('success', 'Meter berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $meter = Meter::findOrFail($id);
        $rooms = Room::orderBy('name')->get();

        return view('dashboard.admin.meters.edit', compact('meter', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        $meter = Meter::findOrFail($id);
        $validated = $this->validateMeter($request);

        $global = $this->getGlobalSettings();
        $period = $this->parsePeriod($validated['period']);

        $billData = $this->calculateTotalBill(
            $validated['water_meter_start'],
            $validated['water_meter_end'],
            $validated['electric_meter_start'],
            $validated['electric_meter_end'],
            $global
        );

        $meter->update(array_merge($validated, $billData, ['period' => $period]));

        return redirect()->route('dashboard.meter.index')->with('success', 'Meter berhasil diperbarui.');
    }

    public function destroy(Meter $meter)
    {
        $meter->delete();
        return redirect()->route('dashboard.meter.index')->with('success', 'Meter berhasil dihapus.');
    }

    // --- PRIVATE HELPERS ---

    private function validateMeter(Request $request): array
    {
        return $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'period' => ['required', 'date'],
            'water_meter_start' => ['required', 'integer', 'min:0'],
            'water_meter_end' => ['required', 'integer', 'gte:water_meter_start'],
            'electric_meter_start' => ['required', 'integer', 'min:0'],
            'electric_meter_end' => ['required', 'integer', 'gte:electric_meter_start'],
        ], [
            'water_meter_end.gte' => 'Meter air akhir harus lebih besar atau sama dengan meter awal.',
            'electric_meter_end.gte' => 'Meter listrik akhir harus lebih besar atau sama dengan meter awal.',
        ]);
    }

    private function getGlobalSettings(): GlobalSetting
    {
        $global = GlobalSetting::first();
        if (!$global) {
            abort(500, 'Global setting tidak ditemukan. Silakan atur terlebih dahulu.');
        }
        return $global;
    }

    private function parsePeriod(string $date): string
    {
        // format YYYY-MM to YYYY-MM-07 (default tanggal billing)
        return $date . '-07';
    }

    private function calculateTotalBill(int $waterStart, int $waterEnd, int $electricStart, int $electricEnd, GlobalSetting $global): array
    {
        $total_water = $waterEnd - $waterStart;
        $total_electric = $electricEnd - $electricStart;
        $total_bill = $global->monthly_room_price +
            ($total_water * $global->water_price) +
            ($total_electric * $global->electric_price);

        return [
            'total_water' => $total_water,
            'total_electric' => $total_electric,
            'total_bill' => $total_bill,
        ];
    }
}
