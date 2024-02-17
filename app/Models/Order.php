<?php

namespace App\Models;

use App\Contracts\Model\PaymentRelationInterface;
use App\Enums\Order\OrderStatusEnum;
use App\Traits\HasModerations;
use App\Traits\PaymentRelatedTrait;
use App\Traits\TableModelSortableFilterableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model implements PaymentRelationInterface
{
    use HasFactory, PaymentRelatedTrait, TableModelSortableFilterableTrait, HasModerations;

    protected $fillable = ['amount', 'status', 'store_id', 'warehouse_id'];

    protected $casts = [
        'status' => OrderStatusEnum::class,
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function customer()
    {
        return $this->hasOne(OrderCustomer::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
