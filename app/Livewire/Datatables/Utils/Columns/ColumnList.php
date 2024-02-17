<?php

namespace App\Livewire\Datatables\Utils\Columns;

use App\Livewire\Datatables\Utils\Columns\Column;
use Illuminate\Support\Collection;

class ColumnList extends Column
{
    protected $view = 'list';

    public function isArray($value)
    {
        return $value instanceof Collection ? true : is_array($value);
    }

    public function count($value)
    {
        if (!$this->isArray($value)) {
            return 1;
        }

        return $value instanceof Collection ? $value->count() : count($value);
    }
}
