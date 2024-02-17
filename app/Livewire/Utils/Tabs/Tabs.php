<?php

namespace App\Livewire\Utils\Tabs;

use App\Livewire\Datatables\Utils\AbstractCollection;
use App\Livewire\Utils\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class Tabs extends AbstractCollection
{

    public function __construct(Tab ...$tabs)
    {
        parent::__construct();

        foreach (array(...$tabs) as $tab) {
            $this->collection->push($tab);
        }
    }

    public function apply(Builder $query, $tab)
    {
        $tab = $this->tab($tab);

        if (!$tab) {
            return $query;
        }

        $relations = explode('.', $tab->field);

        return $this->applyNested(
            $query,
            $relations,
            array_pop($relations),
            $tab->value
        );
    }

    private function applyNested($query, $relations, $attribute, $value)
    {
        if (count($relations) === 1) {
            return $query->where($attribute, $value);
        }

        $relation = array_shift($relations);

        return $query->whereHas($relation, function ($query) use ($relations, $attribute, $value) {
            $this->applyNested($query, $relations, $attribute, $value);
        });
    }

    public function tab(string $key)
    {
        return $this->collection->where('key', $key)->first();
    }
}
