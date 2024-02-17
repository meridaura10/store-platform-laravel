<?php

namespace App\Livewire\Datatables\Utils\Columns;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Column
{
    protected $view = 'text';

    protected Closure|null $customQuery = null;

    public function __construct(
        public string  $key,
        public bool $sortable = true,
        public string|null $title = null,
    ) {
        $this->title = $title ?? $key;
    }
    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }

    public function hasCustomQuery()
    {
        return !is_null($this->customQuery);
    }
    public function getCustomQuery(): Closure|null
    {
        return $this->customQuery;
    }

    public function apply($query, $direction)
    {
        if ($this->hasCustomQuery()) {
            return $this->getCustomQuery()($query, $direction);
        }

        return $query->orderBy($this->key, $direction);
    }

    public function setCustomQuery(Closure|null $customQuery): static
    {
        $this->customQuery = $customQuery;

        return $this;
    }

    public function value(Model $item)
    {
        $relations = explode('.', $this->key);
        $value = $item;

        foreach ($relations as $rel) {
            switch (true) {
                case $value instanceof Model:
                    $value = $value->{$rel};
                    break;
                case $value instanceof Collection:
                    $value = $value->pluck($rel);
                    break;
            }
        }

        return $value;
    }

    public function render(Model $item)
    {
        return view("livewire.datatables.columns.$this->view", [
            'item' => $item,
            'column' => $this,
        ])->render();
    }
}
