<?php

namespace App\Livewire\Datatables;

use App\Livewire\Datatables\Utils\Actions;
use App\Livewire\Datatables\Utils\Columns;
use App\Livewire\Datatables\Utils\Filters;
use App\Livewire\Utils\Tabs\Tabs;
use App\Livewire\Utils\Tabs\Tab;
use App\Traits\FilterableTrait;
use App\Traits\TabsTrait;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

abstract class Table extends Component
{
    use WithPagination, TabsTrait, FilterableTrait;

    private Columns $columns;

    private Actions $actions;

    public $usePagination = true;

    public int $perPage = 15;

    public  $perPages  = [15, 25, 50, 100];

    public $paginationTheme = 'tailwind';

    public $sortKey = null;
    public $sortDirection = false;

    protected $queryString = [
        'f' => ['except' => []],
        'sortKey' => ['except' => null],
        'sortDirection' => ['except' => false],
        'perPage' => ['except' => 15],
        'tab' => ['except' => null],
    ];
    public function __construct()
    {
        $this->initTable();
    }

    protected function initTable()
    {
        $this->columns = $this->columns();
        $this->actions = $this->actions();

        $this->initTabs();
        $this->initFilters();

        $this->usePagination = $this->usePagination();
    }

    public function getColumns()
    {
        return $this->columns;
    }

    // ===================== GENERATING FUNCTIONS ================ //

    public function usePagination(): bool
    {
        return true;
    }


    public function actions(): Actions
    {
        return new Actions();
    }


    public function hasActions(): bool
    {
        return $this->actions->count() > 0;
    }


    // ============ MANDATORY FUNCTIONS ============== //

    abstract public function model(): string;

    abstract public function columns(): Columns;



    // ============== BUILDER ================ //

    private function makeQuery(): Builder
    {
        return $this->model()::query();
    }

    public function extendQuery(Builder $builder)
    {
        $builder;
    }

    public function resultQuery(Builder $builder)
    {
        if ($this->usePagination) {
            $paginateItems = $builder->paginate($this->perPage);

            if ($paginateItems->isEmpty()) {
                $this->resetPage();

                return $builder->paginate($this->perPage);
            }

            return $paginateItems;
        }
        return $builder->limit(30)->get();
    }

    public function sortQuery(Builder $builder)
    {
        $builder->sorting($this->columns, $this->sortKey, $this->sortDirection ? 'asc' : 'desc');
    }

   

    // =================== SORTING ================= //
    public function setSort(string $column = null, bool $direction = true)
    {
        $this->sortKey = $column;
        $this->sortDirection = $direction;
    }

    public function sortByNext(string $column)
    {
        if ($this->sortKey == $column) {
            if ($this->sortDirection) {
                $this->setSort($column, false);
            } else {
                $this->setSort();
            }
        } else {
            $this->setSort($column);
        }
    }


    // =============== INPUTS ================ //

    public function action(string $key, string $id)
    {
        $action = $this->actions->action($key);

        if ($action->confirm) {
            $this->dispatch('modal-confirm-open', $action->confirmTitle, $action->confirmText, 'datatable-action-confirm', [$key, $id]);
        } else {
            $this->actionConfirmed($key, $id);
        }
    }

    #[On('datatable-action-confirm')]
    public function actionListener(array $data = null)
    {
        [$key, $id] = $data;
        $action = $this->actions->action($key);
        if ($action) {
            $this->actionConfirmed($key, $id);
        }
    }

    public function actionConfirmed(string $key, string $id)
    {
        $action = $this->actions->action($key);
        $model = $this->makeQuery()->find($id);

        $action->call($this, $model);
    }

    // =============== TITLE ================ //

    public function hasTitle(): bool
    {
        return false;
    }

    public function getTitle(): string
    {

        return 'Title';
    }


    // =============== LINKS ================ //


    public function hasCreatedLink()
    {
        return !!$this->getCreatedLink();
    }

    public function getCreatedLink()
    {
        return false;
    }

    // =============== ITEMS ================ //

    protected function items()
    {
        $builder = $this->makeQuery();
        $this->extendQuery($builder);
        $this->sortQuery($builder);
        $this->tabsQuery($builder);
        $this->filterQuery($builder);


        return $this->resultQuery($builder);
    }

    public function updatedPerPage($value)
    {
        $this->setPage(1);
    }

    public function updatedF()
    {
        $this->setPage(1);
    }

    public function openEditModal($id, $key)
    {
        $column = $this->columns->column($key);
        $model = $this->makeQuery()->find($id);

        if ($column && $model) {
            $this->emit('open-edit-text', $id, $key, $column->value($model), $column->title);
        }
    }

    public function actionEditField($key, $item)
    {
        $column = $this->getColumns()->column($key);
        $this->dispatch('modal-edit-field-open', [
            'item' => $item,
            'field' => $key,
            'model' => $this->model(),
            'values' => $column->getEditValues(),
            'title' => $column->getModelTitle(),
        ]);
    }

    public function columnEdited($id, $key, $value)
    {
        $column = $this->columns->column($key);
        $model = $this->makeQuery()->find($id);

        if ($column && $model) {

            $method = Str::camel("edit_$key");
            if (method_exists($this, $method)) {
                $this->{$method}($model, $value);
            } else {
                throw new Exception("Method: $method not exists for your table. Create \"$method\" method for edit $key column.");
            }
        }
    }

    public function switchChange($key, $id)
    {
        $method = Str::camel("switch_$key");
        if (method_exists($this, $method)) {
            $model = $this->makeQuery()->find($id);
            $this->{$method}($model);
        } else {
            throw new Exception("Method: $method not exists for your table. Create \"$method\" method for switch status.");
        }
    }

    // ================ RENDER ================ //
    #[On('refresh-table')]
    public function render(): View
    {
        return view('livewire.datatables.table', [
            'columns' => $this->columns,
            'filters' => $this->filters,
            'actions' => $this->actions,
            'tabs' => $this->tabs,
            'items' => $this->items(),
        ]);
    }
}
