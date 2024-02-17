<?php 

namespace App\Traits;

use App\Models\Payment;

trait PaymentExpirationTrait
{
    public function isPaymentExpired(Payment $payment): bool
    {
        $paymentExpiration = $payment->payment_expired_time;

        return $paymentExpiration && now()->greaterThan($paymentExpiration);
    }
}
