<?php 

namespace App\Livewire\Utils\Sorts;

use App\Livewire\Datatables\Utils\AbstractCollection;
use Illuminate\Contracts\Database\Query\Builder;


class Sorts extends AbstractCollection
{
    public function __construct(Sort ...$sorts)
    {
        parent::__construct();

        foreach (array(...$sorts) as $sort) {
            $this->collection->push($sort);
        }
    }
    public function sort(string $key)
    {
        return $this->collection->where('key', $key)->first();
    }
}
