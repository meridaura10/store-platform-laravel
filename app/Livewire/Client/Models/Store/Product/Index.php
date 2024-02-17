<?php

namespace App\Livewire\Client\Models\Store\Product;

use App\Livewire\Client\Models\Product\AbstractList;
use App\Livewire\Datatables\Utils\Filters;
use App\Livewire\Utils\Filters\Filter;
use App\Livewire\Utils\Filters\FilterCheckBox;
use App\Livewire\Utils\Filters\FilterRange;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends AbstractList
{
    public Store $store;

    public function mount(Store $store)
    {
        $this->store = $store;

        $this->updatedF();
    }

    public function extendsQuery($query)
    {
        return $query
            ->active()
            ->whereStore($this->store->id)
            ->with('translations', 'store.image', 'store.translations', 'image');
    }

    public function filters(): Filters
    {
        return new Filters(
            Filter::make(
                key: 'search',
                title: 'Пошук',
            )->setCustomQuery(function ($q, $value) {
                return $q->search($value);
            }),
            FilterRange::make(
                key: 'price',
                title: 'Ціна',
                attributes: [
                    'max' => Product::query()->active()->whereStore($this->store->id)->max('price'),
                    'min' => Product::query()->active()->whereStore($this->store->id)->min('price'),
                ],
            ),
        );
    }

    public function contentHeader(): View|null
    {
        return view('client.components.store.catalog-header', [
            'store' => $this->store,
        ]);
    }
}
