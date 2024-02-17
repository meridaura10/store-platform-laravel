<?php

namespace App\Livewire\Datatables\Utils\Columns;

use App\Livewire\Datatables\Utils\Columns\Column;

class ColumnEdit extends Column
{
    protected $view = 'edit-text';

    private $editValues = [];

    private $modalTitle = '';

    public function setEditValues(array $values): static
    {
        $this->editValues = $values;

        return $this;
    }

    public function setModalTitle(string $title): static
    {
        $this->modalTitle = $title;

        return $this;
    }

    public function getModelTitle()
    {
        return $this->modalTitle;
    }

    public function getEditValues(): array
    {
        return $this->editValues;
    }
}
