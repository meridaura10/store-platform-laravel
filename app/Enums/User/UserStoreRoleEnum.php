<?php

namespace App\Enums\User;
use App\Traits\EnumToArrayTrait;

enum UserStoreRoleEnum: string
{
    use EnumToArrayTrait;
    case StoreOwner = 'store owner';

    case StoreAdmin = 'store admin';

    case StoreContentManager = 'store content manager';
}