<?php

namespace App\Http\Controllers;

use App\Models\Meter;
use App\Models\Room;
use App\Models\User;
use App\Models\GlobalSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeterController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->get('year', now()->year);

        $availableYears = Meter::selectRaw('YEAR(period) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (!in_array(now()->year, $availableYears)) {
            $availableYears[] = now()->year;
            rsort($availableYears);
        } else {
            usort($availableYears, function($a, $b) { return $b - $a; });
        }

        $rooms = Room::orderBy('name')->get();

        $roomMeters = [];
        $meterReadingsForStats = collect();

        foreach ($rooms as $room) {
            $readingsForRoom = Meter::with('room')
                ->where('room_id', $room->id)
                ->whereYear('period', $selectedYear)
                ->orderBy('period', 'desc')
                ->get()
                ->map(function ($reading) {
                    $reading->month = Carbon::parse($reading->period)->month;
                    $reading->total_water = $reading->total_water ?? ($reading->water_meter_end - $reading->water_meter_start);
                    $reading->total_electric = $reading->total_electric ?? ($reading->electric_meter_end - $reading->electric_meter_start);
                    return $reading;
                });

            $roomMeters[$room->id] = $readingsForRoom;
            $meterReadingsForStats = $meterReadingsForStats->concat($readingsForRoom);
        }

        $yearlyStats = [
            'total_water' => $meterReadingsForStats->sum('total_water'),
            'total_electric' => $meterReadingsForStats->sum('total_electric'),
        ];

        $totalReadings = $meterReadingsForStats->count();

        return view('dashboard.admin.meters.index', compact(
            'rooms',
            'roomMeters',
            'availableYears',
            'selectedYear',
            'yearlyStats',
            'totalReadings'
        ));
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

    public function destroy($id)
    {
        $meter = Meter::findOrFail($id);
        $meter->delete();
        return redirect()->route('dashboard.meter.index')->with('success', 'Meter berhasil dihapus.');
    }

    public function getMeterDetails($id)
    {
        $meter = Meter::with('room')->findOrFail($id);

        $meter->total_water = $meter->total_water ?? ($meter->water_meter_end - $meter->water_meter_start);
        $meter->total_electric = $meter->total_electric ?? ($meter->electric_meter_end - $meter->electric_meter_start);

        $html = view('dashboard.admin.meters.partials.detail', compact('meter'))->render();

        return response()->json(['html' => $html]);
    }

    public function getRoomDetails($roomId, Request $request)
    {
        $year = $request->get('year', now()->year);

        $room = Room::findOrFail($roomId);

        $readings = Meter::where('room_id', $roomId)
            ->whereYear('period', $year)
            ->orderBy('period', 'desc')
            ->get()
            ->map(function ($reading) {
                $reading->total_water = $reading->total_water ?? ($reading->water_meter_end - $reading->water_meter_start);
                $reading->total_electric = $reading->total_electric ?? ($reading->electric_meter_end - $reading->electric_meter_start);
                return $reading;
            });

        $html = view('dashboard.admin.meters.partials.room-details', compact('room', 'readings', 'year'))->render();

        return response()->json(['html' => $html]);
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