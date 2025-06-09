<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class PaymentHistoryController extends Controller
{
    public function index(){
        $user = auth()->user();
        $transactions = Transaction::where('user_id', $user->id)->orderBy('created_at', 'asc')->paginate(10);
        return view('dashboard.tenants.payment-history.index', compact('transactions'));
    }
}
