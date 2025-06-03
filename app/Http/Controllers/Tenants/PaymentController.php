<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Transaction;
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

            // Cek apakah sudah ada transaksi yang pending atau success untuk meter ini
            $existingTransaction = Transaction::where('meter_id', $meter->id)
                ->whereIn('status', ['pending', 'success'])
                ->first();

            if ($existingTransaction) {
                if ($existingTransaction->status === 'success') {
                    return response()->json(['error' => 'Tagihan untuk periode ini sudah dibayar'], 400);
                }
                
                // Jika ada transaksi pending, return snap token yang sudah ada
                if ($existingTransaction->snap_token) {
                    return response()->json(['token' => $existingTransaction->snap_token]);
                }
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

            // Generate unique order ID
            $orderId = 'INV-' . now()->format('ymd') . '-' . substr(md5($meter->id), 0, 6);

            // Konfigurasi Midtrans
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // Data transaksi
            $transaction_details = [
                'order_id' => $orderId,
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

            // Create or update transaction record
            if ($existingTransaction && $existingTransaction->status === 'pending') {
                // Update existing pending transaction
                $existingTransaction->update([
                    'order_id' => $orderId,
                    'amount' => $totalBill,
                    'snap_token' => $snapToken,
                    'status' => 'pending'
                ]);
                $transaction = $existingTransaction;
            } else {
                // Create new transaction record
                $transaction = Transaction::create([
                    'order_id' => $orderId,
                    'user_id' => $user->id,
                    'meter_id' => $meter->id,
                    'amount' => $totalBill,
                    'status' => 'pending',
                    'snap_token' => $snapToken,
                ]);
            }

            return response()->json([
                'token' => $snapToken,
                'transaction_id' => $transaction->id,
                'amount' => $totalBill
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
