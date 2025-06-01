<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Meter;
use App\Models\GlobalSetting;

class PaymentController extends Controller
{
    public function getSnapToken(Request $request)
    {
        try {
            $user = auth()->user();
            $month = (int) $request->input('month', now()->month);
            $year = (int) $request->input('year', now()->year);

            $meter = Meter::where('room_id', $user->room_id)
                ->where('user_id', $user->id)
                ->whereMonth('period', $month)
                ->whereYear('period', $year)
                ->first();

            if (!$meter) {
                return response()->json(['error' => 'Data meter tidak ditemukan'], 404);
            }

            $global = GlobalSetting::first();

            if (!$global) {
                return response()->json(['error' => 'Global setting tidak ditemukan'], 500);
            }

            $waterUsage = max(0, $meter->water_meter_end - $meter->water_meter_start);
            $electricUsage = max(0, $meter->electric_meter_end - $meter->electric_meter_start);
            $totalBill = ($waterUsage * $global->water_price) +
                        ($electricUsage * $global->electric_price) +
                        $global->monthly_room_price;

            // Konfigurasi Midtrans
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // Data transaksi
            $transaction_details = [
                'order_id' => uniqid('INV-'),
                'gross_amount' => $totalBill,
            ];

            $customer_details = [
                'first_name' => $user->name,
                'email' => $user->email,
            ];

            $params = [
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
