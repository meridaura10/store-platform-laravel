<?php

namespace App\Models;

use App\Enums\Advertisement\AdvertisementStatuses;
use App\Enums\Moderation\ModerationStatusesEnum;
use App\Traits\HasModerations;
use App\Traits\ImageRelatedTrait;
use App\Traits\TableModelSortableFilterableTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Translatable, ImageRelatedTrait, TableModelSortableFilterableTrait, HasModerations;

    protected $fillable = ['status', 'price', 'slug', 'quantity', 'store_id'];

    public $translatedAttributes = ['title', 'description'];

    protected $casts = [
        'status' => 'bool',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeWhereStore($query, $value)
    {

        return $query->where('store_id', $value);
    }

    public function scopeActive($query)
    {
        $query->where('quantity', '>', 0)
            ->whereHas('moderation', function ($q) {
                $q->where('status', ModerationStatusesEnum::Approved);
            })
            ->where('status', true);
    }

    public function scopeSearch($query, $value)
    {
        $query->whereTranslationLike('title', "%$value%");
    }

    public function scopeWithCategory($query,$categoryId)
{
    return $query->whereHas('categories', function ($q) use ($categoryId) {
        $q->where('category_id', $categoryId);
    });
}

    public function scopeSortByTitle($query, $value)
    {
        $query->orderByTranslation('title');
    }
}
