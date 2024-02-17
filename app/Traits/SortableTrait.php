<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Livewire\Utils\Sorts\Sorts;

trait SortableTrait
{
    protected Sorts $sorts;

    public $sort;

    public function initSorts()
    {
        $this->sorts = $this->sorts();
    }

    public function sorts(): Sorts
    {
        return new Sorts;
    }

    public function sortingQuery($query)
    {
        if ($this->sort) {
            // dd($this->sorts->sort($this->sort));
            return $this->sorts->sort($this->sort)?->apply($query);
        }
    }
}
