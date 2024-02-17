<?php

namespace App\Services\Payment\Systems\Card;

use App\Contracts\Model\PaymentRelationInterface;
use App\Contracts\Payment\PaymentSystemCardInterface;
use App\Contracts\Payment\PaymentSystemInterface;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentSystemEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Models\Payment;
use App\Services\Payment\Api\LiqPayApiService;
use App\Traits\PaymentExpirationTrait;


class LiqPayCardService implements PaymentSystemInterface, PaymentSystemCardInterface
{
    use PaymentExpirationTrait;

    private LiqPayApiService $liqPayApiService;

    public function __construct()
    {
        $this->liqPayApiService = new LiqPayApiService;
    }

    public function pay(Payment $payment): void
    {
        try {
            $paymentUrl = $this->getPaymentUrl($payment);

            if (!$paymentUrl) {
                throw new \Exception('Failed to create payment URL');
            }

            redirect($paymentUrl);
        } catch (\Exception $e) {
            throw new \Exception('Failed to pay fondy card: ' . $e->getMessage());
        }
    }

    private function getPaymentUrl(Payment $payment): string|false
    {
        $paymentUrl = $payment->payment_page_url;

        if (!$paymentUrl) {
            $paymentUrl = $this->createCheckoutUrl($payment);
        }

        return $paymentUrl;
    }

    public function createCheckoutUrl(Payment $payment): string|false
    {
        try {
            $url = $this->liqPayApiService->checkout($payment);

            $payment->update([
                'payment_page_url' => $url,
                'payment_expired_time' => now()->addHour(),
            ]);

            return $url;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function getStatus(Payment $payment): PaymentStatusEnum
    {
        try {
            $status = $this->liqPayApiService->getStatus($payment);

            switch ($status->status) {
                case 'reversed':
                case 'failure':
                    return PaymentStatusEnum::Failed;
                case 'success':
                    return PaymentStatusEnum::Completed;
                case 'try_again':
                    return PaymentStatusEnum::Failed;
                case 'error':
                    return PaymentStatusEnum::Failed;
            }
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function response(\Illuminate\Http\Request $request, Payment $payment): Payment
    {
        try {
            $payment->update([
                'status' => $this->getStatus($payment),
            ]);

            return $payment;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function createPayment(PaymentRelationInterface $model, int $amount): Payment
    {
        return $model->payment()->create([
            'type' => PaymentTypeEnum::Card,
            'system' => PaymentSystemEnum::LiqPay,
            'status' => PaymentStatusEnum::Processing,
            'amount' => $amount,
        ]);
    }

    public function updatePayment(Payment $payment, array $data)
    {
        return $payment->update([
            ...$data,
            'type' => PaymentTypeEnum::Card,
            'system' => PaymentSystemEnum::LiqPay,
        ]);
    }
}
