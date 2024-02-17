<?php


namespace App\Livewire\Datatables\Utils\Filters;

use App\Livewire\Utils\Filters\Filter;


class DatatableFilter extends Filter
{
    protected function baseView(): string
    {
        return 'livewire.datatables.filters';
    }
}
