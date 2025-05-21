<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Meter;
use App\Models\Room;
use App\Models\User;
use App\Models\GlobalSetting;

class TenantDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $user = auth()->user();
    $room = $user->room;

    $month = (int) $request->input('month', now()->month);
    $year = (int) $request->input('year', now()->year);

    // Ambil semua tahun tersedia dari kolom `period`
    $availableYears = Meter::where('room_id', $user->room_id)
        ->selectRaw('YEAR(period) as year')
        ->distinct()
        ->pluck('year')
        ->toArray();

    // Ambil meter berdasarkan kolom `period`
    $meter = Meter::where('room_id', $user->room_id)
        ->whereMonth('period', $month)
        ->whereYear('period', $year)
        ->first();

    $global = GlobalSetting::first();

    // Hitung pemakaian
    $waterUsage = 0;
    $electricUsage = 0;
    $totalBill = 0;

    if ($meter && $global) {
        $waterUsage = max(0, $meter->water_meter_end - $meter->water_meter_start);
        $electricUsage = max(0, $meter->electric_meter_end - $meter->electric_meter_start);

        $totalBill = ($waterUsage * $global->water_price) +
                     ($electricUsage * $global->electric_price) +
                     $global->monthly_room_price;
    }

    return view('dashboard.tenants.home.index', compact(
        'user', 'room', 'month', 'year', 'meter', 'global',
        'availableYears', 'totalBill', 'waterUsage', 'electricUsage'
    ));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
