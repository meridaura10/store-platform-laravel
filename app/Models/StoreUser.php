<?php

namespace App\Models;

use App\Traits\TableModelSortableFilterableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreUser extends Model
{
    use HasFactory, TableModelSortableFilterableTrait;

    protected $fillable = ['user_id', 'store_id', 'status'];

    protected $table = 'store_user';

    protected $casts = [
        'status' => 'bool',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function scopeWhereStore($query, $value)
    {
        $query->where('store_id', $value);
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function scopeSearch($query, $value)
    {
        return $query->whereHas('user', function ($query) use ($value) {
            $query->search($value);
        });
    }
}
