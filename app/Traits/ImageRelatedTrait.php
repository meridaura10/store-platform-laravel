<?php

namespace App\Traits;

use App\Models\Image;

trait ImageRelatedTrait
{
    public function image()
    {
        return $this->morphOne(Image::class, 'relation')->orderBy('order', 'asc');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'relation')->orderBy('order');
    }
}
