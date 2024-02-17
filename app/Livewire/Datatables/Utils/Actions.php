<?php

namespace App\Livewire\Datatables\Utils;

use App\Livewire\Datatables\Utils\AbstractCollection;
use App\Livewire\Datatables\Utils\Actions\Action;
class Actions extends AbstractCollection
{

    public function __construct(Action ... $actions)
    {
        parent::__construct();

        foreach(array(... $actions) as $action) {
            $this->collection->push($action);
        }
    }

    public function action(string $key)
    {
        return $this->collection->where('key', $key)->first();
    }


}
