<?php

namespace App\Livewire\Forms;

use App\Enums\Order\OrderStatusEnum;
use App\Enums\Payment\PaymentCardEnum;
use App\Enums\Payment\PaymentSystemEnum;
use App\Enums\Payment\PaymentTypeEnum;
use App\Models\Order;
use App\Services\Order\OrderUpdater;
use App\Services\Payment\Helpers\PaymentTypeHelper;
use App\Traits\FillModelFormTrait;
use Livewire\Form;

class OrderForm extends Form
{
    use FillModelFormTrait;

    public $order;

    public $warehouse;

    public $city;

    public $area;

    public $orderProducts;

    public $customer;

    public $payment = [
        'type' => null,
        'system' => null,
    ];

    public function init(Order $order)
    {
        $this->initForm($order, ['warehouse.city.area', 'warehouse.city', 'warehouse', 'payment', 'orderProducts', 'customer'], 'order');
    }

    public function rules()
    {
        $rules = [
            'customer.last_name' => ['required', 'string', 'max:255'],
            'customer.first_name' => ['required', 'string', 'max:255'],
            'customer.patronymics' => ['required', 'string', 'max:20'],
            'customer.phone' => ['required', 'string', 'max:20'],
            'orderProducts' => ['array', 'required'],
            'orderProducts.*.quantity' => ['required'],
            'orderProducts.*.product' => ['required', 'array'],
            'orderProducts.*.id' => ['nullable', 'exists:order_products,id'],
        ];

        $rules["payment.type"] = ['required', 'in:' . implode(',', PaymentTypeEnum::values())];
        $rules["area"] = ['required', 'array'];
        $rules["area.id"] = ['required', 'exists:areas,id'];
        $rules["city"] = ['required', 'array'];
        $rules["city.id"] = ['required', 'exists:cities,id'];
        $rules["warehouse"] = ['required', 'array'];
        $rules["warehouse.id"] = ['required', 'exists:warehouses,id'];
        if ($this->payment['type'] === PaymentTypeEnum::Cash->value) {
            $rules["payment.system"] = ['nullable'];
        } else {
            $rules["payment.system"] = ['required', 'in:' . implode(',', PaymentCardEnum::values())];
        }

        return $rules;
    }

    public function setArea(array|null $area)
    {
        $this->area = $area;
    }

    public function setCity(array|null $city)
    {
        $this->city = $city;
    }

    public function setWarehouse(array|null $warehouse)
    {
        $this->warehouse = $warehouse;
    }

    public function removeProduct($key)
    {
        unset($this->orderProducts[$key]);
    }

    public function AddNewProduct($product)
    {
        if (!in_array($product['product']['id'], array_column($this->orderProducts, 'product_id'))) {
            $this->orderProducts[] = $product;
        };
    }

    public function save()
    {
        $data = $this->validate();
        $orderUpdater = new OrderUpdater;

        $orderUpdater->update($this->order, $data);
    }
}
