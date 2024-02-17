<?php

namespace App\Enums\User;

use App\Traits\EnumToArrayTrait;

enum UserRightTypeEnum: string
{
    use EnumToArrayTrait;

    case Admin = 'admin';
    
    case Store = 'store';
}
