<?php

namespace App\Services\Payment\Factories;

use App\Contracts\Payment\Factory\PaymentFactoryInterface;
use App\Contracts\Payment\PaymentSystemInterface;
use App\Enums\Payment\PaymentSystemEnum;
use App\Services\Payment\Systems\Card\FondyCardService;
use App\Services\Payment\Systems\Card\LiqPayCardService;

class PaymentCardFactory implements PaymentFactoryInterface
{
    public function createPaymentSystem($system): PaymentSystemInterface
    {
        switch ($system) {
            case PaymentSystemEnum::Fondy->value:
                return new FondyCardService();

            case PaymentSystemEnum::LiqPay->value:
                return new LiqPayCardService();

            default:
                throw new \Exception('not found system ' . $system . 'to card payment');
        }
    }
}
