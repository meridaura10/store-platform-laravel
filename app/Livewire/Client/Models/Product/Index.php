<?php

namespace App\Livewire\Client\Models\Product;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    private  $products;
    public function mount()
    {
        $this->products = Product::query()
            ->active()
            ->with('translations','image')
            ->paginate(20);
    }
    public function render()
    {
        return view('livewire.client.models.product.index', [
            'products' => $this->products,
        ]);
    }
}
