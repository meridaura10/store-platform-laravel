<?php

namespace App\Livewire\Utils\Sorts;

use Illuminate\Contracts\Database\Query\Builder;


class Sort
{
  public function __construct(
    public string $key,
    public string|null $field = null,
    public string|null $title = null,
    public string|null $relatedField = null,
    public string|null $direction = 'asc',
    public string|null $scope = null
  ) {
    $this->key = $key;
    $this->field = $field ?? $key;
    $this->title = $title ?? $key;
  }

  public static function make(...$arguments): static
  {
    return new static(...$arguments);
  }

  public function apply(Builder $query): Builder
  {
    if ($this->scope) {
      return $query->{$this->scope}($this->direction);
    }

    return $query->orderBy($this->field, $this->direction);
  }

  public function render()
  {

    return view("livewire.utils.sorts.option", [
      'sort' => $this,
    ])->render();
  }
}
