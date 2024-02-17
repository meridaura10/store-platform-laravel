<?php

namespace App\Services\Payment\Systems\Cash;

use App\Contracts\Model\PaymentRelationInterface;
use App\Contracts\Payment\PaymentSystemInterface;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentSystemEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Models\Payment;
use App\Services\Payment\PaymentCreator;
use App\Traits\PaymentExpirationTrait;
use Illuminate\Database\Eloquent\Model;

class PaymentCasheService implements PaymentSystemInterface
{
    use PaymentExpirationTrait;

    public function pay(Payment $payment): void
    {
        dd("pay cash");
    }

    public function createPayment(PaymentRelationInterface $model, int $amount): Payment
    {
        return $model->payment()->create([
            'type' => PaymentTypeEnum::Cash,
            'system' => PaymentSystemEnum::Cash,
            'status' => PaymentStatusEnum::Processing,
            'amount' => $amount,
        ]);
    }

    public function updatePayment(Payment $payment, array $data)
    {
        return $payment->update([
            ...$data,
            'type' => PaymentTypeEnum::Cash,
            'system' => PaymentSystemEnum::Cash,
        ]);
    }
}
