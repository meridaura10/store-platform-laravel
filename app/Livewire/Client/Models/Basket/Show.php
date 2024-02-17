<?php

namespace App\Livewire\Client\Models\Basket;

use App\Models\BasketProduct;
use Livewire\Component;

class Show extends Component
{

    public function mount()
    {
      
    }

    public function update(BasketProduct $basketProduct, $quantity)
    {
        basket()->updateBasketProductQuantity($basketProduct, $quantity);
        $this->dispatch('update-basket-quantity');
    }

    public function removeProduct(BasketProduct $basketProduct)
    {
        basket()->removeBasketProduct($basketProduct);
        $this->dispatch('update-basket-quantity');
    }

    public function render()
    {
        return view('livewire.client.models.basket.show');
    }
}
