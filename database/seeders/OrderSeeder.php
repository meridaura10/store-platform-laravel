<?php

namespace Database\Seeders;

use App\Enums\Order\OrderStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Payment\PaymentSystemEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Models\Warehouse;
use App\Services\Payment\Helpers\PaymentTypeHelper;
use Arcanedev\Support\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        try {
            DB::beginTransaction();

            foreach (Store::all(['id']) as $store) {
                for ($i = 0; $i < 30; $i++) {
                    $randomProducts = Product::query()->where('quantity', '>', '4')->inRandomOrder()->limit(5)->get();

                    $orderProducts = [];
                    $totalSum = 0;

                    foreach ($randomProducts as $key => $product) {
                        $orderProducts[$key]['price'] = $product->price;
                        $orderProducts[$key]['quantity'] = fake()->numberBetween(2, 4);
                        $orderProducts[$key]['product_id'] = $product->id;
                        $totalSum = $totalSum + $orderProducts[$key]['price'] *  $orderProducts[$key]['quantity'];
                        array_push($orderProducts[$key], $product->getTranslationsArray());
                    }


                    $order = Order::create([
                        'status' => OrderStatusEnum::Processing,
                        'amount' => $totalSum,
                        'warehouse_id' => Warehouse::query()->inRandomOrder()->first()->id,
                        'store_id' => $store->id,
                    ]);

                    $order->customer()->create([
                        'user_id' => User::query()->inRandomOrder()->first()->id,
                        'phone' => fake()->phoneNumber(),
                        'first_name' => fake()->firstName(),
                        'last_name' => fake()->lastName(),
                        'patronymics' => fake()->word(),
                    ]);

                    $order->moderation()->create();

                    $order->payment()->create([
                        'type' => PaymentTypeEnum::Cash,
                        'system' => PaymentSystemEnum::Cash,
                        'status' => PaymentStatusEnum::Pending,
                        'amount' => $totalSum,
                    ]);

                    foreach ($orderProducts as $product) {
                        $trans = array_pop($product);
                        $order->orderProducts()->create($product)->update($trans);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
