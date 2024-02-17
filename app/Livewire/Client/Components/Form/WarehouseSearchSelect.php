<?php

namespace App\Livewire\Client\Components\Form;

use App\Livewire\Utils\Form\SearchSelect;
use App\Models\Warehouse;
use Livewire\Component;

class WarehouseSearchSelect extends SearchSelect
{
    
    public function model(): string
    {
        return Warehouse::class;
    }
}
