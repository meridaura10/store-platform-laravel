<?php

namespace App\Policies;

use App\Enums\User\UserRightTypeEnum;
use App\Models\Product;
use App\Models\User;
use App\Traits\HasStorePolicy;
use App\Traits\UserRightTypePolicyTrait;

class ProductPolicy
{
    use UserRightTypePolicyTrait;

    public function update(User $user, Product $product, int|null $storeId = null): bool
    {
        if ($product->store_id !== $storeId) {
            return false;
        }

        return $user->hasPermission('update products',  $this->getType($storeId), $storeId);
    }

    public function create(User $user, Product $product, int|null $storeId = null): bool
    {
        return $user->hasPermission('create products',  $this->getType($storeId), $storeId);
    }

    public function delete(User $user, Product $product, int|null $storeId = null): bool
    {
        if ($product->store_id !== $storeId) {
            return false;
        }



        return $user->hasPermission('delete products', $this->getType($storeId), $storeId);
    }
}
