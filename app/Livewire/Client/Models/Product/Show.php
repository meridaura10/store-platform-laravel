<?php

namespace App\Livewire\Client\Models\Product;

use App\Models\Product;
use Livewire\Component;

class Show extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product->load(['translations', 'images']);
    }

    public function addToBasket()
    {
        basket()->createBasketProduct($this->product);
        $this->dispatch('update-basket-quantity');
    }

    public function render()
    {
        return view('livewire.client.models.product.show');
    }
}
