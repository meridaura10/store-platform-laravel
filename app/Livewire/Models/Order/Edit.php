<?php

namespace App\Livewire\Models\Order;

use App\Livewire\Forms\OrderForm;
use App\Models\Order;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public OrderForm $form;

    public function mount(Order $order)
    {
        $order->load('payment', 'warehouse.city.area', 'orderProducts.product.image', 'orderProducts.translations', 'customer');
        $this->form->init($order);
    }

    #[On('set-selected-area')]
    public function setSelectedArea(array|null $area)
    {
        $this->form->setArea($area);

        if ($area) {
            $this->dispatch("order-update-city-dependes", [
                'field' => 'area_id',
                'value' => $area['id'],
            ]);
        }
    }

    #[On('set-selected-new-product')]
    public function AddNewProduct($product)
    {
        $this->form->AddNewProduct([
            'quantity' => 1,
            'product' => $product,
        ]);
    }

    #[On('set-selected-city')]
    public function setSelectedCity(array|null $city)
    {
        $this->form->setCity($city);

        if ($city) {
            $this->dispatch("order-update-warehouse-dependes", [
                'field' => 'city_id',
                'value' => $city['id'],
            ]);
        }
    }

    #[On('set-selected-warehouse')]
    public function setSelectedWarehouse(array|null  $warehouse)
    {
        $this->form->setWarehouse($warehouse);
    }

    public function removeProduct($key)
    {
        $this->form->removeProduct($key);
    }

    public function save()
    {
        $this->form->save();
    }

    public function render()
    {
        return view('livewire.models.order.edit');
    }
}
