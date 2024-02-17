<?php

namespace App\Policies;

use App\Enums\User\UserRightTypeEnum;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;

class StorePolicy
{
    public function update(User $user, Store $store, UserRightTypeEnum $type): bool
    {
        return $user->hasPermission('update stores', $type, $store->id);
    }

    public function view(User $user, Store $store, UserRightTypeEnum $type): bool
    {
        return $user->hasPermission('view stores', $type, $store->id);
    }

    public function delete(User $user, Store $store, UserRightTypeEnum $type): bool
    {
        return $user->hasPermission('delete stores', $type, $store->id);
    }
}
