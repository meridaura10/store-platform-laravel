<?php

namespace App\Livewire\Store\Models\Shop;

use Livewire\Component;

class Index extends Component
{
    private $shop;

    public function mount()
    {
        $this->shop = auth()->user()->shop()->first();
    }
    
    public function render()
    {
        return view('livewire.store.models.shop.index',[
            'shop' => $this->shop,
        ]);
    }
}
