<?php

namespace App\Enums\User;
use App\Traits\EnumToArrayTrait;

enum UserAdminRoleEnum: string
{
    use EnumToArrayTrait;
    case admin = 'admin';
    case contentManager = 'content manager';
}