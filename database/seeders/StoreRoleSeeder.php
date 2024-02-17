<?php

namespace Database\Seeders;

use App\Enums\User\UserRightTypeEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Store;
use App\Models\StoreUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreRoleSeeder extends Seeder
{
    public function run(): void
    {
        $stores = Store::active()->get();


        foreach ($stores as $store) {
            $users = $store->users;

            if ($users->isEmpty()) {
                $users = User::query()
                    ->limit(3)
                    ->inRandomOrder()
                    ->get();
            }

            $admin = Role::updateOrCreate([
                'title' => 'admin',
                'type' => UserRightTypeEnum::Store,
                'store_id' => $store->id
            ]);

            $permissions = Permission::where('type', UserRightTypeEnum::Store)->get(['id']);
            $admin->permissions()->sync($permissions);

            $productManager = Role::updateOrCreate([
                'title' => 'product manager',
                'type' => UserRightTypeEnum::Store,
                'store_id' => $store->id,
            ]);

            $permissions = Permission::whereIn('id', [10, 11, 12, 13, 14])->get(['id']);
            $productManager->permissions()->sync($permissions);

            $orderManager = Role::updateOrCreate([
                'title' => 'order manager',
                'type' => UserRightTypeEnum::Store,
                'store_id' => $store->id,
            ]);

            $permissions = Permission::whereIn('id', [9, 8, 7])->get(['id']);
            $orderManager->permissions()->sync($permissions);


            $user = $users[0];
            $storeUser = StoreUser::updateOrCreate(
                [
                    'store_id' => $store->id,
                    'user_id' => $user->id,
                ],
                [
                    'status' => 1,
                ]
            );

            $storeUser->roles()->sync($admin);


            $user = $users[1];
            $storeUser = StoreUser::updateOrCreate(
                [
                    'store_id' => $store->id,
                    'user_id' => $user->id,
                ],
                [
                    'status' => 1,
                ]
            );

            $storeUser->roles()->sync($productManager);
            $user = $users[2];
            $storeUser = StoreUser::updateOrCreate(
                [
                    'store_id' => $store->id,
                    'user_id' => $user->id,
                ],
                [
                    'status' => 1,
                ]
            );


            $storeUser->roles()->sync($orderManager);
        }
    }
}
