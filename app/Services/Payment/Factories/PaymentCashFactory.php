<?php

namespace App\Services\Payment\Factories;

use App\Contracts\Payment\Factory\PaymentFactoryInterface;
use App\Contracts\Payment\PaymentSystemInterface;
use App\Services\Payment\Systems\Cash\PaymentCasheService;

class PaymentCashFactory implements PaymentFactoryInterface
{
    public function createPaymentSystem($system): PaymentSystemInterface
    {
        return new PaymentCasheService();
        // switch ($system) {
        //     case PaymentSystemEnum::Cash->value:
        // return new PaymentCasheService();
        //     default:
        //         throw new \Exception('not found system ' . $system . 'to cashe payment');
        // }
    }
}
