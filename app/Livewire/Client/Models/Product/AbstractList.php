<?php

namespace App\Livewire\Client\Models\Product;

use App\Livewire\Utils\Sorts\Sort;
use App\Livewire\Utils\Sorts\Sorts;
use App\Models\Product;
use App\Traits\FilterableTrait;
use App\Traits\SortableTrait;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AbstractList extends Component
{
    use FilterableTrait, SortableTrait;

    protected $queryString = ['f', 'sort'];

    public function makeQuery()
    {
        return Product::query();
    }

    public function boot()
    {
        $this->initFilters();
        $this->initSorts();
    }

    public function extendsQuery($query)
    {
        return $query->with('translations', 'store.image', 'store.translations', 'image');
    }

    public function products()
    {
        $builder = $this->makeQuery();

        $this->extendsQuery($builder);
        $this->filterQuery($builder);
        $this->sortingQuery($builder);

        return $builder->paginate(20);
    }

    public function sorts(): Sorts
    {
        return new Sorts(
            Sort::make(
                key: 'cheap',
                field: 'price',
                title: trans('base.from_cheap_to_expensive'),
            ),
            Sort::make(
                key: 'expensive',
                field: 'price',
                direction: 'desc',
                title: trans('base.from_expensive_to_cheap'),
            ),
            Sort::make(
                key: 'novelty',
                field: 'created_at',
                direction: 'desc',
                title: trans('novelty'),
            ),
        );
    }


    public function contentHeader(): View|null
    {
        return null;
    }

    public function clearFilter($key = null, $value = null)
    {
        if (!$key) {
            $this->f = [];
            $this->updatedF();
            return;
        }

        $filter = $this->filters->filter($key);

        if (!$filter) {
            $this->f = [];
            $this->updatedF();
            return;
        }

        if ($value != null) {

            unset($this->f[$filter->key][$value]);
            return;
        }

        unset($this->f[$filter->key]);
    }

    public function render()
    {
        return view('livewire.client.models.product.abstract-list', [
            'products' => $this->products(),
            'filters' => $this->filters,
            'sorts' => $this->sorts,
        ]);
    }
}
