<?php

namespace App\Services\Payment;

use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentSystemEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class PaymentCreator
{
    protected Payment $payment;

    public function __construct()
    {
        $this->payment = new Payment();
    }

    public function setAmount(float $amount): self
    {
        $this->payment->amount = $amount;
        return $this;
    }

    public function setType(PaymentTypeEnum $type): self
    {
        $this->payment->type = $type;
        return $this;
    }

    public function setSystem(PaymentSystemEnum $system): self
    {
        $this->payment->system = $system;
        return $this;
    }

    public function setPayable(Model $payable): self
    {
        $this->payment->payable()->associate($payable);
        return $this;
    }

    public function setStatus(PaymentStatusEnum $status): self
    {
        $this->payment->status = $status;
        return $this;
    }

    public function save(): Payment
    {
        $this->payment->save();
        return $this->payment;
    }
}
