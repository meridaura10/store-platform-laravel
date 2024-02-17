<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketProduct extends Model
{
    use HasFactory;

    protected $fillable = ['basket_id', 'product_id', 'quantity'];

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
