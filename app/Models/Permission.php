<?php

namespace App\Models;

use App\Enums\User\UserRightTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type'];

    protected $casts = [
        'type' => UserRightTypeEnum::class,
    ];
}
