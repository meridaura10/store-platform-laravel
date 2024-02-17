<?php

namespace App\Livewire\Store\Components\Form;

use App\Livewire\Utils\Form\SearchSelect;
use App\Models\User;
use Livewire\Component;

class UserSearchSelect extends SearchSelect
{
    public function model(): string
    {
        return User::class;
    }

    public function fillables(): array
    {
        return [
            'title' => 'name',
            'value' => 'id',
        ];
    }
}
