<?php

namespace App\Enums\Store;


enum StoreStatusEnum: string
{
    case Now = "Now";

    case Setting = 'Setting';

    case Approved = "Approved";
}
