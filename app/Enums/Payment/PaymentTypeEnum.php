<?php

namespace App\Enums\Payment;

use App\Traits\EnumToArrayTrait;


enum PaymentTypeEnum: string
{
    use EnumToArrayTrait;

    case Cash = "Cash";

    case Card = "Card";

    case Installment = 'Installment';
}
