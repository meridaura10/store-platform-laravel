<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\User\UserRightTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role',
        'warning',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'bool',
        'password' => 'hashed',
    ];

    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function storeUsers()
    {
        return $this->hasMany(StoreUser::class);
    }

    public function storeUser($store_id)
    {
        return $this->hasOne(StoreUser::class)->where('store_id', $store_id)->first();
    }

    public function basket()
    {
        return $this->hasOne(Basket::class);
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%')
            ->orWhere('email', 'like', '%' . $value . '%');
    }

    // public function scopeStoreUser($query, $value)
    // {
    //     $this->stores()->where('store_id', $value);
    // }

    public function hasPermission($permission, UserRightTypeEnum $type, $storeId = null): bool
    {
        if ($type === UserRightTypeEnum::Store) {
            $query = $this->storeUser($storeId)->roles()->where('type', $type);
        }

        if ($type === UserRightTypeEnum::Admin) {
            $query = $this->roles()->where('type', $type);
        }

        return $query->whereHas('permissions', function ($query) use ($permission, $type) {
            $query->where('title', $permission)->where('type', $type);
        })->exists();
    }
}
