<?php

namespace App\Actions;

use App\Contracts\Payment\PaymentSystemCardInterface;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Payment\Helpers\PaymentTypeHelper;
use Illuminate\Http\Request;

class PaymentResponseAction
{
    public function handle(Request $request, Payment $payment)
    {
        try {
            $paymentSystem = PaymentTypeHelper::createPaymentSystem($payment);

            if ($paymentSystem instanceof PaymentSystemCardInterface) {

                $payment = $paymentSystem->response($request, $payment);
            }

            switch ($payment->payable->getMorphClass()) {
                case Order::class:
                    return redirect()->route('user.cabinet.order.index');

                default:
                return redirect()->route('client.index');
            }
            
        } catch (\Throwable $th) {
            dd($th);
            throw new \Exception($th->getMessage());
        }
    }
}
