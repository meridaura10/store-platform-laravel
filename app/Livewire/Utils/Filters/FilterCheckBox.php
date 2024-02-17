<?php

namespace App\Livewire\Utils\Filters;

class FilterCheckBox extends Filter
{
    protected  $view = 'check-box';
    protected  $type = 'check-box';

    private array $values = [];

    public function setValues(array $values): static
    {
        $this->values = $values;

        return $this;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function applyFilter(\Illuminate\Database\Eloquent\Builder $query, $values)
    {
        if ($this->relatedField) {
            return $query->whereHas($this->relatedField, function ($query) use ($values) {
                $query->whereIn($this->field, array_keys($values));
            });
        }

        return $query->whereIn($this->field, $values);
    }

    public function validateF(&$f)
    {
        if (array_key_exists($this->key, $f)) {
            return;
        }
        
        $f[$this->key] = [];
    }
}
