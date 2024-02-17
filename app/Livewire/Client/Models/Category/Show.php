<?php

namespace App\Livewire\Client\Models\Category;

use App\Livewire\Client\Models\Product\AbstractList;
use App\Livewire\Datatables\Utils\Filters;
use App\Livewire\Utils\Filters\Filter;
use App\Livewire\Utils\Filters\FilterCheckBox;
use App\Livewire\Utils\Filters\FilterRange;
use App\Livewire\Utils\Sorts\Sort;
use App\Livewire\Utils\Sorts\Sorts;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends AbstractList
{
    public Category $category;

    public function mount(Category $category)
    {
        $this->category = $category;

        $this->updatedF();
    }

    public function extendsQuery($query)
    {
        return $query
            ->active()
            ->withCategory($this->category->id)
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
                    'max' => Product::query()->active()->withCategory($this->category->id)->max('price'),
                    'min' => Product::query()->active()->withCategory($this->category->id)->min('price'),
                ],
            ),
            FilterCheckBox::make(
                key: 'stores',
                title: 'Магазини',
                field: 'store_id',
            )->setValues(
                Store::query()
                    ->whereHas('products', function ($q) {
                        $q->active()->withCategory($this->category->id);
                    })
                    ->active()
                    ->with('translations')
                    ->get()
                    ->pluck('title', 'id')
                    ->toArray()
            ),

        );
    }

    public function contentHeader(): View|null
    {
        return view('client.components.category.catalog-header', [
            'category' => $this->category,
        ]);
    }
}
