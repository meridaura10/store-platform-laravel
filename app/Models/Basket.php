<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'user_id', 'lifetime'];

    public function basketProducts()
    {
        return $this->hasMany(BasketProduct::class);
    }
}
