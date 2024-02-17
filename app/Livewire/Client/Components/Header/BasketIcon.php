<?php

namespace App\Livewire\Client\Components\Header;

use Livewire\Attributes\On;
use Livewire\Component;

class BasketIcon extends Component
{
    public $quantity = 0;

    public function mount()
    {
        $this->setQuantity();
    }

    #[On('update-basket-quantity')]
    public function setQuantity()
    {
        $this->quantity = basket()->totalQuantity();
    }

    public function render()
    {
        return view('livewire.client.components.header.basket-icon');
    }
}
