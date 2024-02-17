<?php

namespace App\Livewire\Client\Models\Order;

use App\Livewire\Forms\CheckoutForm;
use App\Livewire\Forms\OrderForm;
use Livewire\Attributes\On;
use Livewire\Component;

class Checkout extends Component
{
    public CheckoutForm $form;

    public function mount()
    {
        $this->form->init();
    }

    #[On('set-selected-area')]
    public function setSelectedArea($key, array|null $area)
    {
        $this->form->setArea($key, $area);

        if ($area) {
            $this->dispatch("order-$key-update-city-dependes", [
                'field' => 'area_id',
                'value' => $area['id'],
            ]);
        }
    }

    #[On('set-selected-city')]
    public function setSelectedCity($key, array|null $city)
    {
        $this->form->setCity($key, $city);

        if ($city) {
            $this->dispatch("order-$key-update-warehouse-dependes", [
                'field' => 'city_id',
                'value' => $city['id'],
            ]);
        }
    }

    #[On('set-selected-warehouse')]
    public function setSelectedWarehouse($key, array|null  $warehouse)
    {
        $this->form->setWarehouse($key, $warehouse);
    }

    public function checkout()
    {
        $this->form->checkout();

        redirect()->route('user.cabinet.order.index');
    }

    public function render()
    {
        return view('livewire.client.models.order.checkout');
    }
}
