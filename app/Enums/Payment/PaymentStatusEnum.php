<?php

namespace App\Enums\Payment;
use App\Traits\EnumToArrayTrait;

enum PaymentStatusEnum: string
{
    use EnumToArrayTrait;

    case Pending = "pending";
    
    case Completed = "completed";

    case Failed = "failed";

    case Refunded = "refunded";

    case Processing = "processing";
}
