<?php

namespace App\Models;

use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentSystemEnum;
use App\Enums\Payment\PaymentTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        "amount",
        "status",
        "type",
        "system",
        'payable_id',
        'payment_expired_time',
        'payment_page_url',
        'payable_type',
    ];

    protected $casts = [
        'system' => PaymentSystemEnum::class,
        'type' => PaymentTypeEnum::class,
        'status' => PaymentStatusEnum::class,
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = str()->uuid()->toString();
        });
    }

    public function payable()
    {
        return $this->morphTo();
    }
}
