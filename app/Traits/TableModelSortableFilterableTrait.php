<?php

namespace App\Traits;

use App\Livewire\Datatables\Utils\Columns;
use App\Livewire\Datatables\Utils\Filters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait TableModelSortableFilterableTrait
{
    public function scopeSorting(Builder $query, Columns $columns, $sortKey = null, $direction)
    {
        if ($sortKey && $sortKey !== 'null') {
            $column = $columns->column($sortKey);

            return $column->apply($query, $direction);
        }

        return $query;
    }

    public function scopeFiltered(Builder $query, Filters $filters, $values)
    {
        foreach ($filters as $filter) {
            $query = $filter->apply($query, array_key_exists($filter->key, $values) ? $values[$filter->key] : null);
        }

        return $query;
    }
}
