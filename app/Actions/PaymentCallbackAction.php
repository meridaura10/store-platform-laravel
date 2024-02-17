<?php

namespace App\Actions;

use App\Contracts\Payment\PaymentSystemCardInterface;
use App\Models\Payment;
use App\Services\Payment\Helpers\PaymentTypeHelper;
use Illuminate\Http\Request;

class PaymentCallbackAction
{
    public function handle(Request $request,Payment $payment)
    {
        $paymentSystem = PaymentTypeHelper::createPaymentSystem($payment);

        if ($paymentSystem instanceof PaymentSystemCardInterface) {
            $paymentSystem->response($request, $payment);
        }

        return response()->json(['status' => 'ok'], 200);
    }
}
