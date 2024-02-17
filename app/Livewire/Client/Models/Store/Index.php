<?php

namespace App\Livewire\Client\Models\Store;

use App\Models\Store;
use Livewire\Component;

class Index extends Component
{
    public $stores;

    public function mount()
    {
        $this->stores = Store::query()
            ->active()
            ->limit(6)
            ->with([
                'image',
                'translations',
            ])
            ->get();


        foreach ($this->stores as $store) {
            $store->load(['products' => function ($q) {
                $q->with('image','translations')->take(4);
            }]);
        }
    }

    public function render()
    {
        return view('livewire.client.models.store.index');
    }
}
