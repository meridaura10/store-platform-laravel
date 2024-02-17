<?php

namespace App\Livewire\Utils\Form;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;

abstract class SearchSelect extends Component
{
    public $fillables = [];

    public $prefix = null;

    public $selected;

    public $default;

    public $event;

    public $label;

    public $searchQuery = '';

    public $eventUpdateDependes = null;

    public $dependes = [];

    abstract function model(): string;

    public function fillables(): array
    {
        return [
            'title' => 'title',
            'value' => 'id',
        ];
    }

    protected function getListeners()
    {
        if ($this->eventUpdateDependes) {
            return [
                $this->eventUpdateDependes => 'updateDependes',
            ];
        }

        return [];
    }

    public function mount()
    {
        $this->fillables = $this->fillables();
        $this->selected = $this->default ? $this->find($this->default) : null;
    }

    public function updateDependes($dependes)
    {
        $this->dependes = $dependes;

        if (!$this->selected) {
            return $this->save(null);
        }

        $selected = $this->find($this->selected[$this->fillables['value']]);

        $this->save($selected);
    }

    public function makeQuery(): Builder
    {
        return $this->model()::query();
    }

    public function extendQuery(Builder $builder)
    {
        $builder;
    }

    public function resultQuery(Builder $builder)
    {
        return $builder
            ->limit(10)
            ->get();
    }

    private function find($id)
    {
        $builder = $this->makeQuery();

        $this->dependesQuery($builder);
        $this->extendQuery($builder);

        return $builder->find($id)?->toArray();
    }

    public function options()
    {
        $builder = $this->makeQuery();

        $this->extendQuery($builder);
        $this->searchQuery($builder);
        $this->dependesQuery($builder);

        return $this->resultQuery($builder);
    }

    protected function dependesQuery(Builder $builder)
    {
        if (!$this->dependes) {
            return;
        }

        $builder->where($this->dependes['field'], $this->dependes['value']);
    }

    protected function searchQuery(Builder $builder)
    {
        $builder->where($this->fillables['title'], 'like', '%' . $this->searchQuery . '%');
    }

    public function save($opt)
    {
        $this->selected = $opt;

        if ($this->prefix) {
            return $this->dispatch($this->event, $this->prefix, $opt);
        }

        $this->dispatch($this->event, $opt);

        $this->searchQuery = '';
    }

    public function render()
    {
        return view('livewire.utils.form.search-select', [
            'options' => $this->options(),
        ]);
    }
}
