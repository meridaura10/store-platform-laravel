<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Traits\UserRightTypePolicyTrait;

class RolePolicy
{
    use UserRightTypePolicyTrait;

    public function update(User $user, Role $role ,int|null $storeId = null) : bool
    {
        if ($role->store_id && $role->store_id !== $storeId) {
            return false;
        }

        return $user->hasPermission('update role', $this->getType($storeId), $storeId);
    }

    public function create(User $user, Role $role ,int|null $storeId = null) : bool
    {
        return $user->hasPermission('create role', $this->getType($storeId), $storeId);
    }

    public function delete(User $user, Role $role,int|null $storeId)
    {
        if ($role->store_id && $role->store_id !== $storeId) {
            return false;
        }

        return $user->hasPermission('delete roles', $this->getType($storeId), $storeId);
    }
}
