<?php

namespace App\Enums\Payment;
use App\Traits\EnumToArrayTrait;


enum PaymentSystemEnum: string
{
    use EnumToArrayTrait;
    
    case Fondy = "Fondy";

    case Cash = "cash";

    case LiqPay = "LiqPay";
}