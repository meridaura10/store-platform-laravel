<?php

namespace App\Livewire\Forms;

use App\Contracts\Payment\PaymentSystemInterface;
use App\Enums\Payment\PaymentSystemEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Models\BasketProduct;
use App\Models\Order;
use App\Models\OrderCustomer;
use App\Models\Store;
use App\Models\Warehouse;
use App\Services\Order\OrderCreator;
use App\Services\Payment\Helpers\PaymentTypeHelper;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CheckoutForm extends Form
{
    public $customer = [];

    public $orders = [];

    public function updatepaymentSystem($storeKey, $system = null)
    {
        $this->orders[$storeKey]['payment']['system'] = $system;
    }

    public function rules()
    {
        $rules = [
            'customer.last_name' => ['required', 'string', 'max:255'],
            'customer.first_name' => ['required', 'string', 'max:255'],
            'customer.patronymics' => ['required', 'string', 'max:20'],
            'customer.phone' => ['required', 'string', 'max:20'],
        ];

        foreach (array_keys($this->orders) as $key) {
            $rules["orders.$key.payment.type"] = ['required', 'in:' . implode(',', PaymentTypeEnum::values())];
            $rules["orders.$key.address.area"] = ['required', 'array'];
            $rules["orders.$key.address.area.id"] = ['required', 'exists:areas,id'];
            $rules["orders.$key.address.city"] = ['required', 'array'];
            $rules["orders.$key.address.city.id"] = ['required', 'exists:cities,id'];
            $rules["orders.$key.address.warehouse"] = ['required', 'array'];
            $rules["orders.$key.address.warehouse.id"] = ['required', 'exists:warehouses,id'];
            if ($this->orders[$key]['payment']['type'] === PaymentTypeEnum::Cash->value) {
                $rules["orders.$key.payment.system"] = ['nullable'];
            } else {
                $rules["orders.$key.payment.system"] = ['required', 'in:' . implode(',', PaymentSystemEnum::values())];
            }
        }

        return $rules;
    }


    public function init()
    {
        foreach (basket()->getBasketProductsGroupedByShop() as $key => $storeBasketProducts) {
            $this->orders[$key]['basketProducts'] = $storeBasketProducts->toArray();
            $this->orders[$key]['payment']['type'] = null;
            $this->orders[$key]['payment']['system'] = null;
        }
    }

    public function setArea($orderKey, array|null $area)
    {
        $this->orders[$orderKey]['address']['area'] = $area;
    }

    public function setCity($orderKey, array|null $city)
    {
        $this->orders[$orderKey]['address']['city'] = $city;
    }

    public function setWarehouse($orderKey, array|null $warehouse)
    {
        $this->orders[$orderKey]['address']['warehouse'] = $warehouse;
    }

    public function checkout()
    {
        $data = $this->validate();

        foreach ($data['orders'] as $storeId => $orderData) {
            try {
                $store = Store::query()->active()->findOrFail($storeId);
                $warehouse = Warehouse::query()->findOrFail($orderData['address']['warehouse']['id']);

                OrderCreator::create($store, $warehouse, $data['customer'], $orderData['payment']);
            } catch (\Exception $e) {
                dd($e);
                continue;
            }
        };
    }
}
