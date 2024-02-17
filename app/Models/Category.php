<?php

namespace App\Models;


use App\Traits\ImageRelatedTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Translatable, ImageRelatedTrait;

    public $translatedAttributes = ['title'];
    protected $fillable = ['parent_id', 'status', 'slug'];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id')->with('parent', 'translations', 'image');
    }

    public function subcategories()
    {
        return $this->hasMany(self::class, 'parent_id')->with('subcategories', 'translations', 'image');
    }
}
