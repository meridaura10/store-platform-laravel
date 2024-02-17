<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory, Translatable;

    protected $fillable = ['order_id', 'product_id', 'price', 'quantity'];

    public $translatedAttributes = ['title', 'description'];

    protected $appends = ['sum'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected function sum(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->product->price * $this->quantity
        );
    }
}
