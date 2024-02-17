<?php

namespace App\Livewire\Datatables\Utils\Columns;

use App\Livewire\Datatables\Utils\Columns\Column;

class ColumnImage extends Column
{
    protected $view = 'image';

    public static function make(...$arguments): static
    {
        $arguments['sortable'] = false;
        return new static(...$arguments);
    }
}
