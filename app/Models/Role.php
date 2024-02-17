<?php

namespace App\Models;

use App\Enums\User\UserRightTypeEnum;
use App\Traits\TableModelSortableFilterableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, TableModelSortableFilterableTrait;

    protected $fillable = ['title', 'type', 'store_id'];

    protected $casts = [
        'type' => UserRightTypeEnum::class,
    ];

    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
