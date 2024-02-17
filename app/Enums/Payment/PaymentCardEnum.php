<?php

namespace App\Enums\Payment;

use App\Traits\EnumToArrayTrait;


enum PaymentCardEnum: string
{
    use EnumToArrayTrait;
    case Fondy = "Fondy";
    case LiqPay = "LiqPay";
}
