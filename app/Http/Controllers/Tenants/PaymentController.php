<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Payments\MayarController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $mayarController;

    public function __construct(MayarController $mayarController)
    {
        $this->mayarController = $mayarController;
    }

    public function createPayment(Request $request)
    {
        return $this->mayarController->createPayment($request);
    }

    public function getPaymentStatus($orderId)
    {
        return $this->mayarController->getPaymentStatus($orderId);
    }
}
