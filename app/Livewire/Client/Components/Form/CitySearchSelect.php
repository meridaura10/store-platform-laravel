<?php

namespace App\Livewire\Client\Components\Form;

use App\Livewire\Utils\Form\SearchSelect;
use App\Models\City;
use Livewire\Component;

class CitySearchSelect extends SearchSelect
{
    public function model(): string
    {
        return City::class;
    }
}
