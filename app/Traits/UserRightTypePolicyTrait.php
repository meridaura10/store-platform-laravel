<?php

namespace App\Traits;

use App\Enums\User\UserRightTypeEnum;

trait UserRightTypePolicyTrait
{
    private function getType($storeId = null)
    {
        if ($storeId) {
            return UserRightTypeEnum::Store;
        }

        return UserRightTypeEnum::Admin;
    }
}
