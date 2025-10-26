<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class PaymentHistoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $baseQuery = Transaction::where('user_id', $user->id);

        $totalPaid = (clone $baseQuery)->where('status', 'success')->sum('amount');

        $lastPayment = (clone $baseQuery)->where('status', 'success')->latest('paid_at')->first();

        $transactions = $baseQuery->with('meter')->latest()->paginate(10);

        $lastPaymentDate = $lastPayment?->paid_at;

        return view('dashboard.tenants.payment-history.index', compact('transactions', 'totalPaid', 'lastPaymentDate'));
    }
}
