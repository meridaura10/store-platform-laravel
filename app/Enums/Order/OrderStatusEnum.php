<?php

namespace App\Enums\Order;
use App\Traits\EnumToArrayTrait;

enum OrderStatusEnum: string
{
    use EnumToArrayTrait;

    case Pending = "pending";

    case Completed = "completed";

    case Failed = "failed";

    case Refunded = "refunded";

    case Processing = "processing";
}
