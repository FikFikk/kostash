<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Meter;
use App\Models\Room;
use App\Models\User;
use App\Models\GlobalSetting;
use App\Models\Transaction;

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
        $paymentStatus = null;
        $transaction = null;

        if ($meter && $global) {
            $waterUsage = max(0, $meter->water_meter_end - $meter->water_meter_start);
            $electricUsage = max(0, $meter->electric_meter_end - $meter->electric_meter_start);

            $totalBill = ($waterUsage * $global->water_price) +
                ($electricUsage * $global->electric_price) +
                $global->monthly_room_price;

            // Cek status pembayaran untuk periode ini
            $transaction = Transaction::where('meter_id', $meter->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($transaction) {
                $paymentStatus = $transaction->status;
            }
        }

        return view('dashboard.tenants.home.index', compact(
            'user',
            'room',
            'month',
            'year',
            'meter',
            'global',
            'availableYears',
            'totalBill',
            'waterUsage',
            'electricUsage',
            'paymentStatus',
            'transaction'
        ));
    }

    public function exportInvoice(Request $request)
    {
        $user = auth()->user();
        $room = $user->room;

        $userAgent = $request->header('User-Agent');
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod/i', $userAgent);

        $month = (int) $request->input('month', now()->month);
        $year = (int) $request->input('year', now()->year);

        $meter = Meter::where('room_id', $user->room_id)
            ->whereYear('period', $year)
            ->whereMonth('period', $month)
            ->first();

        $global = GlobalSetting::first();

        $electricUsage = $meter ? max(0, $meter->electric_meter_end - $meter->electric_meter_start) : 0;
        $waterUsage = $meter ? max(0, $meter->water_meter_end - $meter->water_meter_start) : 0;

        $totalBill = ($electricUsage * $global->electric_price) +
            ($waterUsage * $global->water_price) +
            $global->monthly_room_price;

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

        $pdf = Pdf::loadView('dashboard.tenants.pdf.export', $data)
            ->setPaper([0, 0, 842, 700], 'portrait'); // width: A3 = 842pt, height: custom (default A3: 1190pt)

        $filename = 'tagihan_kamar_' . $room->name . '_' . $month . '_' . $year . '.pdf';

        if ($isMobile) {
            return $pdf->download($filename); // Auto download on mobile
        } else {
            return $pdf->stream($filename); // Stream on desktop
        }
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
     * Download payment receipt
     */
    public function downloadReceipt(Transaction $transaction)
    {
        // Verify transaction belongs to current user
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to transaction');
        }

        // Verify transaction is successful
        if ($transaction->status !== 'success') {
            return redirect()->back()->with('error', 'Bukti pembayaran hanya tersedia untuk transaksi yang berhasil');
        }

        $user = auth()->user();
        $meter = $transaction->meter;
        $global = GlobalSetting::first();

        // Calculate usage details
        $waterUsage = $meter ? max(0, $meter->water_meter_end - $meter->water_meter_start) : 0;
        $electricUsage = $meter ? max(0, $meter->electric_meter_end - $meter->electric_meter_start) : 0;

        $pdf = PDF::loadView('dashboard.tenants.receipt', compact(
            'transaction',
            'user',
            'meter',
            'global',
            'waterUsage',
            'electricUsage'
        ));

        $filename = 'receipt-' . $transaction->order_id . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
