<?php

namespace App\Livewire\Store\Components\Form;

use App\Livewire\Utils\Form\SearchSelect;
use App\Models\Product;
use Livewire\Component;

class ProductSearchSelect extends SearchSelect
{
    public function model(): string
    {
        return Product::class;
    }

    public function extendQuery(\Illuminate\Database\Eloquent\Builder $builder){
        $builder->with('translations','image');
    }

    public function searchQuery(\Illuminate\Database\Eloquent\Builder $builder){
        $builder->search($this->searchQuery);
    }

    public function render()
    {
        return view('livewire.store.components.form.prodcut-search-select', [
            'options' => $this->options(),
        ]);
    }
}
