<?php

namespace App\Policies;

use App\Enums\User\UserRightTypeEnum;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use App\Traits\HasStorePolicy;
use App\Traits\UserRightTypePolicyTrait;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    use UserRightTypePolicyTrait;

    public function viewAny(User $user, int|null $storeId = null): bool
    {
        return $user->hasPermission('viewAny orders', $this->getType($storeId), $storeId);
    }

    public function view(User $user, Order $order, int|null $storeId = null): bool
    {
        if ($order->customer->user_id === $user->id) {
            return true;
        }

        if ($order->store_id !== $storeId) {
            return false;
        }

        return $user->hasPermission('view orders', $this->getType($storeId), $storeId);
    }

    public function update(User $user, Order $order,int|null $storeId = null): bool
    {
        if ($order->store_id !== $storeId) {
            return false;
        }

        return $user->hasPermission('update orders', $this->getType($storeId), $storeId);
    }
}
