<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use App\Models\Meter;
use App\Models\Transaction;
use App\Services\MayarService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MayarController extends Controller
{
    protected $mayarService;
    protected $globalSettings;

    public function __construct(MayarService $mayarService)
    {
        $this->mayarService = $mayarService;
        $this->globalSettings = GlobalSetting::first();
    }

    /**
     * Create payment request
     */
    public function createPayment(Request $request)
    {
        try {
            $user = \Illuminate\Support\Facades\Auth::user();
            $meterId = $request->input('meter_id');

            if (!$user || !$user->room_id) {
                Log::warning('User without room trying to create payment', [
                    'user_id' => $user ? $user->id : null
                ]);
                return response()->json(['error' => 'User tidak memiliki kamar'], 400);
            }

            // Get meter data
            $meter = Meter::where('id', $meterId)
                ->where('room_id', $user->room_id)
                ->first();

            if (!$meter) {
                Log::warning('Meter not found or unauthorized access', [
                    'meter_id' => $meterId,
                    'user_id' => $user->id,
                    'room_id' => $user->room_id
                ]);
                return response()->json(['error' => 'Data meter tidak ditemukan'], 404);
            }

            // Check if already paid
            $successTransaction = Transaction::where('meter_id', $meter->id)
                ->where('status', 'success')
                ->first();

            if ($successTransaction) {
                return response()->json(['error' => 'Tagihan untuk periode ini sudah dibayar'], 400);
            }

            // Find existing pending transaction
            $existingTransaction = Transaction::where('meter_id', $meter->id)
                ->where('status', 'pending')
                ->first();

            // Calculate bill amount
            $billAmount = $this->calculateBillAmount($meter);

            // Generate unique order ID
            $orderId = $this->generateOrderId($meter->id);

            // Build payment description with breakdown
            $description = $this->buildPaymentDescription($meter);

            // Create Mayar payment request
            $paymentParams = $this->mayarService->buildPaymentParams(
                $orderId,
                $billAmount,
                $description,
                $user->name,
                $user->email,
                $user->phone
            );

            $paymentResponse = $this->mayarService->createPaymentRequest($paymentParams);

            // Get payment URL
            $paymentUrl = $this->mayarService->getPaymentUrl($paymentResponse);

            // Save or update transaction record
            $transaction = $this->saveTransaction($existingTransaction, [
                'order_id' => $orderId,
                'user_id' => $user->id,
                'meter_id' => $meter->id,
                'amount' => $billAmount,
                'mayar_payment_id' => $paymentResponse['data']['id'],
                'mayar_link' => $paymentResponse['data']['link'],
                'status' => 'pending',
                'payment_type' => 'mayar'
            ]);

            Log::info('Mayar payment created', [
                'order_id' => $orderId,
                'user_id' => $user->id,
                'amount' => $billAmount,
                'payment_id' => $paymentResponse['data']['id']
            ]);

            return response()->json([
                'payment_url' => $paymentUrl,
                'transaction_id' => $transaction->id,
                'amount' => $billAmount,
                'order_id' => $orderId,
                'payment_id' => $paymentResponse['data']['id']
            ]);
        } catch (\Exception $e) {
            Log::error('Mayar payment creation failed', [
                'error' => $e->getMessage(),
                'user_id' => optional(auth())->id(),
                'meter_id' => $meterId ?? null
            ]);

            return response()->json(['error' => 'Gagal membuat pembayaran: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Handle Mayar webhook notification
     */
    public function handleWebhook(Request $request)
    {
        try {
            // Parse webhook data
            $webhookData = $this->mayarService->handleWebhook($request->all());

            Log::info('Mayar webhook received', [
                'payment_id' => $webhookData['payment_id'],
                'status' => $webhookData['status'],
                'order' => $webhookData['order']
            ]);

            // Find transaction by order ID or payment ID
            $transaction = null;

            if ($webhookData['order']) {
                $transaction = Transaction::where('order_id', $webhookData['order'])->first();
            }

            if (!$transaction && $webhookData['payment_id']) {
                $transaction = Transaction::where('mayar_payment_id', $webhookData['payment_id'])->first();
            }

            if (!$transaction) {
                Log::warning('Transaction not found for webhook', [
                    'payment_id' => $webhookData['payment_id'],
                    'order' => $webhookData['order']
                ]);
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Update transaction based on status
            $this->updateTransactionStatus($transaction, $webhookData);

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            Log::error('Mayar webhook handling failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json(['error' => 'Webhook handling failed'], 500);
        }
    }

    /**
     * Payment success page
     */
    public function paymentSuccess(Request $request)
    {
        $orderId = $request->get('order_id');
        $paymentId = $request->get('payment_id');
        $transaction = null;

        if ($orderId) {
            $transaction = Transaction::where('order_id', $orderId)->first();
        } elseif ($paymentId) {
            $transaction = Transaction::where('mayar_payment_id', $paymentId)->first();
        }

        Log::info('Payment success page accessed', [
            'order_id' => $orderId,
            'payment_id' => $paymentId,
            'transaction_found' => $transaction ? true : false
        ]);

        return view('payments.success', compact('transaction'));
    }

    /**
     * Payment pending page
     */
    public function paymentPending(Request $request)
    {
        $orderId = $request->get('order_id');
        $paymentId = $request->get('payment_id');
        $transaction = null;

        if ($orderId) {
            $transaction = Transaction::where('order_id', $orderId)->first();
        } elseif ($paymentId) {
            $transaction = Transaction::where('mayar_payment_id', $paymentId)->first();
        }

        Log::info('Payment pending page accessed', [
            'order_id' => $orderId,
            'payment_id' => $paymentId,
            'transaction_found' => $transaction ? true : false
        ]);

        return view('payments.pending', compact('transaction'));
    }

    /**
     * Payment failed page
     */
    public function paymentFailed(Request $request)
    {
        $orderId = $request->get('order_id');
        $paymentId = $request->get('payment_id');
        $transaction = null;

        if ($orderId) {
            $transaction = Transaction::where('order_id', $orderId)->first();
        } elseif ($paymentId) {
            $transaction = Transaction::where('mayar_payment_id', $paymentId)->first();
        }

        Log::info('Payment failed page accessed', [
            'order_id' => $orderId,
            'payment_id' => $paymentId,
            'transaction_found' => $transaction ? true : false
        ]);

        return view('payments.failed', compact('transaction'));
    }

    /**
     * Calculate bill amount
     */
    private function calculateBillAmount($meter)
    {
        $waterUsage = max(0, $meter->water_meter_end - $meter->water_meter_start);
        $electricUsage = max(0, $meter->electric_meter_end - $meter->electric_meter_start);

        return ($waterUsage * $this->globalSettings->water_price) +
            ($electricUsage * $this->globalSettings->electric_price) +
            $this->globalSettings->monthly_room_price;
    }

    /**
     * Generate unique order ID
     */
    private function generateOrderId($meterId)
    {
        return 'KOS-' . now()->format('ymd') . '-' . substr(md5($meterId . time()), 0, 6);
    }

    /**
     * Build payment description with breakdown
     */
    private function buildPaymentDescription($meter)
    {
        $waterUsage = max(0, $meter->water_meter_end - $meter->water_meter_start);
        $electricUsage = max(0, $meter->electric_meter_end - $meter->electric_meter_start);

        $description = "Tagihan Kos " . ($meter->room->name ?? 'Room') . " - " . $meter->period->format('M Y');

        $breakdown = [];
        $breakdown[] = "Sewa Kamar: Rp " . number_format($this->globalSettings->monthly_room_price, 0, ',', '.');

        if ($waterUsage > 0) {
            $waterAmount = $waterUsage * $this->globalSettings->water_price;
            $breakdown[] = "Air ({$waterUsage}m³): Rp " . number_format($waterAmount, 0, ',', '.');
        }

        if ($electricUsage > 0) {
            $electricAmount = $electricUsage * $this->globalSettings->electric_price;
            $breakdown[] = "Listrik ({$electricUsage}kWh): Rp " . number_format($electricAmount, 0, ',', '.');
        }

        return $description . " | " . implode(", ", $breakdown);
    }

    /**
     * Save or update transaction
     */
    private function saveTransaction($existingTransaction, $data)
    {
        if ($existingTransaction) {
            $existingTransaction->update($data);

            // Notification for transaction update
            if (isset($data['user_id'])) {
                $user = \App\Models\User::find($data['user_id']);
                if ($user) {
                    NotificationService::transaction($user, 'created', $existingTransaction);
                }
            }

            return $existingTransaction;
        }

        $transaction = Transaction::create($data);

        // Notification for new transaction
        if (isset($data['user_id'])) {
            $user = \App\Models\User::find($data['user_id']);
            if ($user) {
                NotificationService::transaction($user, 'created', $transaction);
            }
        }

        return $transaction;
    }

    /**
     * Update transaction status based on webhook data
     */
    private function updateTransactionStatus($transaction, $webhookData)
    {
        $status = $webhookData['status'];
        $oldStatus = $transaction->status;

        Log::info('Updating transaction status', [
            'order_id' => $transaction->order_id,
            'old_status' => $oldStatus,
            'new_status' => $status
        ]);

        $user = \App\Models\User::find($transaction->user_id);

        if ($status === 'paid') {
            $transaction->update([
                'status' => 'success',
                'paid_at' => now(),
                'payment_type' => 'mayar'
            ]);

            // Send success notification
            if ($user) {
                NotificationService::payment($user, 'success', $transaction);
            }
        } elseif ($status === 'unpaid') {
            $transaction->update(['status' => 'pending']);

            // Send pending notification
            if ($user && $oldStatus !== 'pending') {
                NotificationService::payment($user, 'pending', $transaction);
            }
        } elseif ($status === 'expired') {
            $transaction->update(['status' => 'expired']);

            // Send expired notification
            if ($user) {
                NotificationService::payment($user, 'expired', $transaction);
            }
        } elseif ($status === 'cancelled') {
            $transaction->update(['status' => 'cancelled']);

            // Send failed notification
            if ($user) {
                NotificationService::payment($user, 'failed', $transaction);
            }
        }
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus($orderId)
    {
        try {
            $transaction = Transaction::where('order_id', $orderId)->first();

            if (!$transaction) {
                return response()->json(['error' => 'Transaction not found'], 404);
            }

            // Get latest status from Mayar if payment ID exists
            if ($transaction->mayar_payment_id) {
                try {
                    $paymentDetail = $this->mayarService->getPaymentDetail($transaction->mayar_payment_id);
                    $mayarStatus = $paymentDetail['data']['status'];

                    // Update local status if different
                    if ($mayarStatus === 'paid' && $transaction->status !== 'success') {
                        $transaction->update([
                            'status' => 'success',
                            'paid_at' => now()
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::warning('Failed to get status from Mayar', [
                        'payment_id' => $transaction->mayar_payment_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            return response()->json([
                'order_id' => $transaction->order_id,
                'status' => $transaction->status,
                'amount' => $transaction->amount,
                'paid_at' => $transaction->paid_at
            ]);
        } catch (\Exception $e) {
            Log::error('Get payment status failed', [
                'error' => $e->getMessage(),
                'order_id' => $orderId
            ]);

            return response()->json(['error' => 'Failed to get payment status'], 500);
        }
    }
}
