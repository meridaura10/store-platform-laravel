<?php

namespace App\Livewire\Datatables\Utils;

use App\Livewire\Datatables\Utils\AbstractCollection;
use App\Livewire\Datatables\Utils\Columns\Column;
class Columns extends AbstractCollection
{

    public function __construct(Column ... $columns)
    {
        parent::__construct();

        foreach(array(... $columns) as $column) {
            $this->collection->push($column);
        }
    }

    public function column(string $key)
    {
        return $this->collection->where('key', $key)->first();
    }

}
