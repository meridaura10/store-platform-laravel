<?php

namespace App\Models;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Traits\TableModelSortableFilterableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moderation extends Model
{
    use HasFactory, TableModelSortableFilterableTrait;

    protected $fillable = [
        'moderatable_id',
        'moderatable_type',
        'user_id',
        'status',
        'reason',
    ];

    protected $casts = [
        'status' => ModerationStatusesEnum::class
    ];

    public function moderatable()
    {
        return $this->morphTo();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsApprovedAttribute()
    {
        return $this->status == ModerationStatusesEnum::Approved;
    }
}
