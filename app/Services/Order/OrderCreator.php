<?php

namespace App\Services\Order;

use App\Enums\Order\OrderStatusEnum;

use App\Models\BasketProduct;
use App\Models\Order;
use App\Models\OrderCustomer;
use App\Models\Product;
use App\Models\Store;
use App\Models\Warehouse;
use App\Services\Payment\Helpers\PaymentTypeHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderCreator
{
    public static function create(Store $store, Warehouse $warehouse, $customerData, $paymentData): Order
    {
        try {
            DB::beginTransaction();

            $basketProducts = basket()->getBasketProductsToShop($store);
            
            $order = self::createOrder($store, $warehouse, $basketProducts);

            self::createcustomer($order, $customerData);

            self::addProductsToOrder($order, $basketProducts);

            self::createPayment($order, $paymentData);

            self::createModeration($order);

            basket()->clearBasketProductsToStore($store);

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    private static function createModeration(Order $order)
    {
        $order->moderation()->create();
    }

    private static function createPayment(Order $order, array $paymentData)
    {
        $paymentSystem =  PaymentTypeHelper::createPaymentSystemFactory($paymentData['type'])
            ->createPaymentSystem($paymentData['system']);

        $paymentSystem->createPayment($order, $order->amount);
    }

    private static function createcustomer(Order $order, array $customerData)
    {
        return OrderCustomer::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'phone' => $customerData['phone'],
            'first_name' => $customerData['first_name'],
            'last_name' => $customerData['last_name'],
            'patronymics' => $customerData['patronymics'],
        ]);
    }

    private static function createOrder(Store $store, Warehouse $warehouse, Collection $basketProducts): Order
    {
        return Order::create([
            'store_id' => $store->id,
            'warehouse_id' => $warehouse->id,
            'amount' => $basketProducts->sum('sum'),
            'status' => OrderStatusEnum::Pending,
        ]);
    }

    private static function addProductsToOrder(Order $order, Collection $basketProducts): void
    {
        foreach ($basketProducts as $basketProduct) {
            $product = $basketProduct->product;

            if ($product->quantity >= $basketProduct->quantity) {
                self::addProductToOrder($order, $basketProduct);
            } else {
                throw new \Exception('Недостатньо товару на складі');
            }
        }
    }

    private static function addProductToOrder(Order $order, BasketProduct $basketProduct): void
    {
        $order->orderProducts()->create([
            ...$basketProduct->product->getTranslationsArray(),
            'product_id' => $basketProduct->product->id,
            'price' => $basketProduct->product->price,
            'quantity' => $basketProduct->quantity,
        ]);

        $basketProduct->product()->decrement('quantity', $basketProduct->quantity);
    }
}
