<?php

namespace App\Services\Payment\Helpers;

use App\Contracts\Payment\Factory\PaymentFactoryInterface;
use App\Contracts\Payment\PaymentSystemInterface;
use App\Enums\Payment\PaymentTypeEnum;
use App\Models\Payment;
use App\Services\Payment\Factories\PaymentCardFactory;
use App\Services\Payment\Factories\PaymentCashFactory;

class PaymentTypeHelper
{
    public static function createPaymentSystemFactory($type): PaymentFactoryInterface
    {
        switch ($type) {
            case PaymentTypeEnum::Card->value:
                return new PaymentCardFactory();

            case PaymentTypeEnum::Cash->value:
                return new PaymentCashFactory();

            default:
                throw new \Exception('not found payment type:' . $type);
        }
    }

    public static function createPaymentSystem(Payment $payment): PaymentSystemInterface
    {
        return self::createPaymentSystemFactory($payment->type->value)->createPaymentSystem($payment->system->value);
    }
}
