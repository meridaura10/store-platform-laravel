<?php

namespace App\Models;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Enums\Store\StoreStatusEnum;
use App\Traits\HasModerations;
use App\Traits\ImageRelatedTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory, Translatable, ImageRelatedTrait, HasModerations;

    protected $fillable = ['status'];

    public $translatedAttributes = ['title', 'description'];

    protected $casts = [
        'status' => 'bool',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'store_user');
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)->activeModeration($query);
    }
}
