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
    /**
     * Export meter bill as PDF (admin version, reusing tenant export logic)
     */
    public function export($id)
    {
        // Find meter by ID
        $meter = \App\Models\Meter::findOrFail($id);
        $room = $meter->room;
        // Use the explicit user attached to the meter. Do not fallback to users.room_id lookup.
        $user = $meter->user;
        $global = \App\Models\GlobalSetting::first();

        // Calculate month and year from period
        $period = \Carbon\Carbon::parse($meter->period);
        $month = (int) $period->format('m');
        $year = (int) $period->format('Y');

        // Calculate usage
        $electricUsage = max(0, $meter->electric_meter_end - $meter->electric_meter_start);
        $waterUsage = max(0, $meter->water_meter_end - $meter->water_meter_start);
        $totalBill = ($electricUsage * $global->electric_price) + ($waterUsage * $global->water_price) + $global->monthly_room_price;

        // Prepare data for the view
        $data = [
            'user' => $user,
            'room' => $room,
            'month' => $month,
            'year' => $year,
            'meter' => $meter,
            'global' => $global,
            'electricUsage' => $electricUsage,
            'waterUsage' => $waterUsage,
            'totalBill' => $totalBill,
        ];

        // Use DomPDF and QrCode (same as tenant)
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.tenants.pdf.export', $data)
            ->setPaper([0, 0, 842, 700], 'portrait');

        $filename = 'tagihan_kamar_' . $room->name . '_' . $month . '_' . $year . '.pdf';

        // Always stream for admin
        return $pdf->stream($filename);
    }

    /**
     * Preview export as HTML (renders same view used for PDF but returns HTML)
     * This allows front-end to render the export layout and convert to image if needed.
     */
    public function previewExport($id)
    {
        $meter = \App\Models\Meter::findOrFail($id);
        $room = $meter->room;
        // Use the explicit user attached to the meter. Do not fallback to users.room_id lookup.
        $user = $meter->user;
        $global = \App\Models\GlobalSetting::first();

        $period = \Carbon\Carbon::parse($meter->period);
        $month = (int) $period->format('m');
        $year = (int) $period->format('Y');

        $electricUsage = max(0, $meter->electric_meter_end - $meter->electric_meter_start);
        $waterUsage = max(0, $meter->water_meter_end - $meter->water_meter_start);
        $totalBill = ($electricUsage * $global->electric_price) + ($waterUsage * $global->water_price) + $global->monthly_room_price;

        $data = [
            'user' => $user,
            'room' => $room,
            'month' => $month,
            'year' => $year,
            'meter' => $meter,
            'global' => $global,
            'electricUsage' => $electricUsage,
            'waterUsage' => $waterUsage,
            'totalBill' => $totalBill,
        ];

        // Render the same view but return HTML so front-end can render/convert to image
        $html = view('dashboard.tenants.image.export', $data)->render();

        return response()->json(['html' => $html]);
    }
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
            usort($availableYears, function ($a, $b) {
                return $b - $a;
            });
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

        // Prefer the currently authenticated tenant user when creating a meter.
        $authUser = \Illuminate\Support\Facades\Auth::user();
        $user = null;
        if ($authUser && $authUser->role === 'tenants') {
            $user = $authUser;
        }

        // If no authenticated tenant, attempt to find the tenant assigned to the room
        // so existing room assignment will receive ownership for new meter entries.
        if (is_null($user)) {
            $user = User::where('room_id', $validated['room_id'])->where('role', 'tenants')->first();
        }

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

        // If this meter doesn't have an owner yet, try to assign one based on users.room_id
        if (is_null($meter->user_id)) {
            $tenant = User::where('room_id', $meter->room_id)->where('role', 'tenants')->first();
            if ($tenant) {
                $meter->user_id = $tenant->id;
            }
        }

        $meter->update(array_merge($validated, $billData, ['period' => $period, 'user_id' => $meter->user_id]));

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
