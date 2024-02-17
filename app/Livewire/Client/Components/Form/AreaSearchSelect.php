<?php

namespace App\Livewire\Client\Components\Form;

use App\Livewire\Utils\Form\SearchSelect;
use App\Models\Area;
use Livewire\Component;

class AreaSearchSelect extends SearchSelect
{
    public function model(): string
    {
        return Area::class;
    }
}
