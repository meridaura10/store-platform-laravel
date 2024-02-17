<?php

namespace Database\Seeders;

use App\Enums\User\UserRightTypeEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::updateOrCreate(
            ['title' => 'admin', 'type' => UserRightTypeEnum::Admin]
        );

        $permissions = Permission::where('type', UserRightTypeEnum::Admin)->get(['id']);
        $role->permissions()->sync($permissions);

        $role = Role::updateOrCreate(
            ['title' => 'order manager', 'type' => UserRightTypeEnum::Admin]
        );

        $permissions = Permission::whereIn('id', [1, 2, 3,])->get(['id']);
        $role->permissions()->sync($permissions);

        $role = Role::updateOrCreate(
            ['title' => 'store manager', 'type' => UserRightTypeEnum::Admin]
        );

        $permissions = Permission::whereIn('id', [5,6])->get(['id']);
        $role->permissions()->sync($permissions);
    }
}
