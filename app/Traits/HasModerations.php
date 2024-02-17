<?php 

namespace App\Traits;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Models\Moderation;

trait HasModerations
{
    public function moderations()
    {
        return $this->morphMany(Moderation::class, 'moderatable')->latest();
    }

    public function moderation()
    {
        return $this->morphOne(Moderation::class, 'moderatable')->latestOfMany();
    }

    public function scopeActiveModeration($query)
    {
        $query->whereHas('moderation', function ($query) {
            $query->where('status', ModerationStatusesEnum::Approved);
        });
    }
}
