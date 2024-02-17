<?php

namespace App\Livewire\Utils\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Filter
{
    protected $type = 'text';

    protected $view = 'input';

    protected Closure|null $customQuery = null;
    public function __construct(
        public string $key,
        public string|null $title = null,
        public string|null $field = null,
        public string|null $relatedField = null,
        public array $attributes = [],
    ) {
        $this->field = $field ?? $key;
        $this->title = $title ?? $key;
    }

    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }

    public function type()
    {
        return $this->type;
    }

    public function hasCustomQuery()
    {
        return !is_null($this->customQuery);
    }

    public function getCustomQuery(): Closure|null
    {
        return $this->customQuery;
    }

    public function setCustomQuery(Closure|null $customQuery): static
    {
        $this->customQuery = $customQuery;

        return $this;
    }

    public function apply(Builder $query, $value): Builder
    {
        if (!$value) {
            return $query;
        }

        if ($this->hasCustomQuery()) {
            return $this->getCustomQuery()($query, $value);
        }

        return $this->applyFilter($query, $value);
    }

    protected function applyFilter(Builder $query, $value)
    {
        return $query->when($this->relatedField, function ($query) use ($value) {
            return is_array($value)
                ? $query->whereHas($this->field, function (Builder $q) use ($value) {
                    return $q->whereIn($this->relatedField, $value);
                })
                : $query->whereHas($this->field, function (Builder $q) use ($value) {
                    return $q->where($this->relatedField, '=', $value);
                });
        })->when($this->type === 'text', function ($query) use ($value) {
            return $query->where($this->field, 'like', '%' . $value . '%');
        })->when($this->type === 'numeric', function ($query) use ($value) {
            return $query->where($this->field, '=', $value);
        })->when($this->type === 'array', function ($query) use ($value) {
            return $query->whereIn($this->field, $value);
        });
    }

    public function validateF(&$f)
    {
        if (!isset($f[$this->key])) {
            $f[$this->key] = '';
        }
    }

    protected function baseView(): string
    {
        return 'livewire.utils.filters';
    }


    public function render()
    {
        return view($this->baseView() . ".$this->view", [
            'filter' => $this,
        ])->render();
    }
}
