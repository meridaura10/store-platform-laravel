<?php

namespace App\Models;

use App\Enums\User\UserStoreRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleStoreUser extends Model
{
    use HasFactory;

    protected $table = 'role_store_user';

    protected $fillable = ['store_user_id', 'role_id'];
}
