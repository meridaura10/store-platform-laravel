<?php

namespace App\Livewire\Utils\Filters;

use Carbon\Carbon;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterDate extends Filter
{
    protected $view = 'date';

    protected $type = 'date';

    protected function applyFilter(Builder $query, $value): Builder
    {
        $date = Carbon::parse($value)->startOfDay();
        $endDate = $date->copy()->endOfDay();

        return $query->where('created_at', '>=', $date)
            ->where('created_at', '<=', $endDate);
    }
}
