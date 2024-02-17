<?php

namespace App\Enums\Moderation;
use App\Traits\EnumToArrayTrait;


enum ModerationStatusesEnum: string
{
    use EnumToArrayTrait;
    case Now = "Now";
    case Refused = "Refused";
    case Approved = "Approved";
    case InProgress = "InProgress"; 
    case Recheck = "Recheck";
}