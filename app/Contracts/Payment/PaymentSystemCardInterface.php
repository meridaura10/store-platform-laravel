<?php

namespace App\Contracts\Payment;

use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Payment;
use Illuminate\Http\Request;

interface PaymentSystemCardInterface
{
    public function createCheckoutUrl(Payment $payment): string|false;

    public function response(Request $request, Payment $payment): Payment;

    public function isPaymentExpired(Payment $payment): bool;

    public function getStatus(Payment $payment): PaymentStatusEnum;
}
