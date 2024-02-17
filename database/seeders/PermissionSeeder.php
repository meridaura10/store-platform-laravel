<?php

namespace Database\Seeders;

use App\Enums\User\UserRightTypeEnum;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'viewAny orders',
                'type' => UserRightTypeEnum::Admin,
            ],
            [
                'title' => 'view orders',
                'type' => UserRightTypeEnum::Admin,
            ],
            [
                'title' => 'update orders',
                'type' => UserRightTypeEnum::Admin,
            ],
            [
                'title' => 'viewAny stores',
                'type' => UserRightTypeEnum::Admin,
            ],
            [
                'title' => 'view stores',
                'type' => UserRightTypeEnum::Admin,
            ],
            [
                'title' => 'update stores',
                'type' => UserRightTypeEnum::Admin,
            ],
            // 7
            [
                'title' => 'viewAny orders',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'view orders',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'update orders',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'viewAny products',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'view products',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'create products',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'delete products',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'update products',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'create staff',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'update staff',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'update roles',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'create roles',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'view stores',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'update stores',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'delete stores',
                'type' => UserRightTypeEnum::Store,
            ],
            [
                'title' => 'delete roles',
                'type' => UserRightTypeEnum::Store,
            ],
        ];

        foreach ($data as $value) {
            Permission::updateOrCreate($value);
        }
    }
}
