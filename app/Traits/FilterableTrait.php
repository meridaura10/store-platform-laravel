<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Livewire\Datatables\Utils\Filters;

trait FilterableTrait
{
    protected Filters $filters;

    public array $f = [];

    public function filters(): Filters
    {
        return new Filters();
    }

    public function hasFilters(): bool
    {
        return $this->filters->count() > 0;
    }

    public function getFilterValue(string $key): mixed
    {
        return $this->f[$key] ?? null;
    }

    private function filterQuery(Builder $builder)
    {
        $builder->filtered($this->filters, $this->f);
    }

    public function hasFilter()
    {
        return count($this->f) > 0 ? count(array_filter(array_values($this->f), fn ($i) => !empty($i))) : false;
    }

    public function clearFilter()
    {
        $this->f = [];
        $this->updatedF();
    }

    public function initFilters()
    {
        $this->filters = $this->filters();
    }

    public function updatedF()
    {
        $this->filters->validateF($this->f);
    }
}
