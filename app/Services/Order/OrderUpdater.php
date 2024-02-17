<?php

namespace App\Services\Order;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentSystemEnum;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Warehouse;
use App\Services\Payment\Helpers\PaymentTypeHelper;
use Illuminate\Support\Facades\DB;

class OrderUpdater
{
    public function update(Order $order, array $data)
    {
        try {
            $this->updateOrderProducts($order, $data['orderProducts']);
            $this->updateOrder($order, $data['warehouse']);
            $this->updateCustomer($order, $data['customer']);
            $this->updatePayment($order, $data['payment']);
            $this->updateModeration($order);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    private function updateModeration(Order $order)
    {
        $order->moderation->update([
            'status' => ModerationStatusesEnum::Recheck,
            'reason' => 'update order',
        ]);
    }

    private function updateOrderProducts(Order $order, array $orderProducts)
    {

        $toNotDeleteIds = array_map(function ($productData) use ($order) {

            if (array_key_exists('id', $productData) && $productData['id']) {
                $orderProduct = $order->orderProducts()->findOrFail($productData['id']);
            } else {
                $product = $productData['product'];
                $trans = array_reduce($product['translations'], function ($carry, $item) {
                    $carry[$item['locale']] = [
                        'title' => $item['title'],
                        'description' => $item['description']
                    ];
                    return $carry;
                }, []);
                $orderProduct = $order->orderProducts()->create([
                    'price' => $product['price'],
                    'quantity' => $productData['quantity'],
                    'product_id' => $product['id'],
                    ...$trans,
                ]);
            }

            if ($orderProduct->product->quantity >= $productData['quantity']) {
                $orderProduct->update($productData);
            } else {
                throw new \Exception('Недостатньо товару на складі');
            }

            return $orderProduct->id;
        }, $orderProducts);


        $order->orderProducts()->whereNotIn('id', $toNotDeleteIds)->delete();
    }

    private function updateOrder(Order $order, array $warehouse)
    {
        $order->update([
            'amount' => $order->orderProducts->sum('sum'),
            'status' => OrderStatusEnum::Pending,
            'warehouse_id' => $warehouse['id'],
        ]);
    }

    private function updateCustomer(Order $order, array $customerData)
    {
        $order->customer->update($customerData);
    }

    private function updatePayment(Order $order, array $paymentData)
    {
        $paymentData['amount'] = $order['amount'];
        $paymentService = PaymentTypeHelper::createPaymentSystemFactory($paymentData['type'])->createPaymentSystem($paymentData['system']);
        $paymentService->updatePayment($order->payment, $paymentData);
    }
}
