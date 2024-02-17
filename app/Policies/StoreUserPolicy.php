<?php

namespace App\Policies;

use App\Enums\User\UserRightTypeEnum;
use App\Models\StoreUser;
use App\Models\User;
use App\Traits\HasStorePolicy;

class StoreUserPolicy
{
    public function update(User $user, StoreUser $storeUser,int|null $storeId = null): bool
    {
        if ($storeUser->store_id !== $storeId) {
            return false;
        }

        return $user->hasPermission('update staff', UserRightTypeEnum::Store, $storeId);
    }

    public function create(User $user, StoreUser $storeUser,int|nullF $storeId = null): bool
    {


        return $user->hasPermission('create staff', UserRightTypeEnum::Store, $storeId);
    }
}
