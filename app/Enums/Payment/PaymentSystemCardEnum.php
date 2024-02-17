<?php

namespace App\Enums\Payment;

enum PaymentSystemCardEnum: string
{
    case Fondy = "Fondy";
    case LiqPay = "LiqPay";
}
