<?php

namespace App\Jobs;

use App\Contracts\Payment\PaymentSystemCardInterface;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Models\Payment;
use App\Services\Payment\Helpers\PaymentTypeHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckStatusPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $payments = Payment::where('type', PaymentTypeEnum::Card->value)
            ->where('status', PaymentStatusEnum::Processing->value)
            ->with('payable')
            ->get();

        foreach ($payments as $payment) {
            $service = PaymentTypeHelper::createPaymentSystem($payment);

            if ($service instanceof PaymentSystemCardInterface) {
                $status = $service->getStatus($payment);

                $payment->update([
                    'status' => $status,
                ]);
            }
        }
    }
}
