<?php

namespace App\Contracts\Payment\Factory;

use App\Contracts\Payment\PaymentSystemInterface;

interface PaymentFactoryInterface
{
    public function createPaymentSystem($system): PaymentSystemInterface;
}
