<?php

namespace App\Contracts\Payment;

use App\Contracts\Model\PaymentRelationInterface;
use App\Models\Payment;

interface PaymentSystemInterface
{
    public function pay(Payment $payment): void;
    
    public function createPayment(PaymentRelationInterface $model, int $amount): Payment;

    public function updatePayment(Payment $payment,array $data);

    public function isPaymentExpired(Payment $payment): bool;
}
