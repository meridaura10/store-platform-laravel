<?php

namespace Database\Seeders;

use App\Enums\User\UserAdminRoleEnum;
use App\Enums\User\UserStoreRoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(298)->create();

        $user = User::updateOrCreate(
            [
                'email' => 'admin@g.com',
            ],
            [
                'password' => Hash::make('admin'),
                'name' => fake()->name(),
            ]
        );

        $user->roles()->attach(Role::find(1));
    }
}
