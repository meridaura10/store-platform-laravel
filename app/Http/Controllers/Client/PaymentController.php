<?php

namespace App\Http\Controllers\Client;

use App\Actions\PaymentResponseAction;
use App\Actions\PaymentCallbackAction;
use App\Contracts\Payment\PaymentSystemCardInterface;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Payment\Helpers\PaymentTypeHelper;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function response(Request $request, Payment $payment, PaymentResponseAction $paymentResponseAction)
    {
        try {
            return  $paymentResponseAction->handle($request, $payment);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function callback(Request $request, Payment $payment, PaymentCallbackAction $paymentCallbackAction)
    {
        try {
            return $paymentCallbackAction->handle($request, $payment);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error'], 500);
        }
    }
}
