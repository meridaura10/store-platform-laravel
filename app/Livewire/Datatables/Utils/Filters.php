<?php

namespace App\Livewire\Datatables\Utils;

use App\Livewire\Datatables\Utils\AbstractCollection;
use App\Livewire\Utils\Filters\Filter;

class Filters extends AbstractCollection
{

    public function __construct(Filter ...$columns)
    {
        parent::__construct();

        foreach (array(...$columns) as $column) {
            $this->collection->push($column);
        }
    }

    public function filter(string $key)
    {
        return $this->collection->where('key', $key)->first();
    }

    public function validateF(&$f)
    {
        foreach ($this->collection as $filter) {
            $filter->validateF($f);
        }
    }
}
