<?php

namespace App\Services\Payment\Systems\Card;

use App\Contracts\Model\PaymentRelationInterface;
use App\Contracts\Payment\PaymentSystemCardInterface;
use App\Contracts\Payment\PaymentSystemInterface;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentSystemEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Models\Payment;
use App\Services\Payment\Api\FondyApiService;
use App\Traits\PaymentExpirationTrait;
use Cloudipsp\Checkout;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class FondyCardService extends FondyApiService implements PaymentSystemInterface, PaymentSystemCardInterface
{
    use PaymentExpirationTrait;

    public function pay(Payment $payment): void
    {
        try {
            $paymentUrl = $this->getPaymentUrl($payment);

            if (!$paymentUrl) {
                throw new \Exception('Failed to create payment URL');
            }

            redirect($paymentUrl);
        } catch (\Exception $e) {
            Log::error('Error in pay method: ' . $e->getMessage());
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
            $lifetime = 3600;

            $data = [
                'order_desc' => 'tests SDK',
                'currency' => 'UAH',
                'order_id' => $payment->id,
                'amount' => intval($payment->amount * 100),
                'response_url' => route("payment.response", ['payment' => $payment->id]),
                'server_callback_url' => route("payment.callback", ['payment' => $payment->id]),
                'lang' => 'ua',
                'lifetime' => $lifetime,
            ];

            $url = Checkout::url($data)->getUrl();

            $payment->update([
                'payment_page_url' => $url,
                'payment_expired_time' => now()->addSeconds($lifetime),
            ]);

            return $url;
        } catch (\Throwable $th) {
            Log::error('Error in createCheckoutUrl method: ' . $th->getMessage());
            return false;
        }
    }

    public function response(Request $request, Payment $payment): Payment
    {
        $result = new \Cloudipsp\Result\Result($request->all(), 'test');


        if ($result->isApproved()) {
            $payment->update([
                'status' => PaymentStatusEnum::Completed->value,
            ]);
        }

        if ($result->isDeclined() || $result->isExpired()) {
            $payment->update([
                'status' => PaymentStatusEnum::Failed->value,
            ]);
        }
        return $payment;
    }

    public function getStatus(Payment $payment): PaymentStatusEnum
    {
        try {
            $orderStatus = \Cloudipsp\Order::status([
                'order_id' => $payment->id,
            ]);

            switch ($orderStatus) {
                case "created":
                    return PaymentStatusEnum::Processing;
                case "processing":
                    return PaymentStatusEnum::Processing;
                case "declined":
                    return PaymentStatusEnum::Failed;
                case  "approved":
                    return PaymentStatusEnum::Completed;
                case "expired":
                    return PaymentStatusEnum::Failed;
                case  "reversed":
                    return PaymentStatusEnum::Refunded;
                default:
                    return PaymentStatusEnum::Processing;
            }
        } catch (\Throwable $th) {
            Log::error('Error in getStatus method: ' . $th->getMessage());
            throw new \Exception('error to getStatus payment to fondy card');
        }
    }

    public function createPayment(PaymentRelationInterface $model, int $amount): Payment
    {
        try {
            return $model->payment()->create([
                'type' => PaymentTypeEnum::Card,
                'system' => PaymentSystemEnum::Fondy,
                'status' => PaymentStatusEnum::Processing,
                'amount' => $amount,
            ]);
        } catch (\Throwable $th) {
            Log::error('Error in createPayment method: ' . $th->getMessage());
            throw new \Exception('error to create payment to fondy card');
        }
    }

    public function updatePayment(Payment $payment, array $data)
    {
        return $payment->update([
            ...$data,
            'type' => PaymentTypeEnum::Card,
            'system' => PaymentSystemEnum::Fondy,
        ]);
    }
}
