<?php

namespace App\Livewire\Datatables\Utils\Actions;

use App\Livewire\Datatables\Table;
use Exception;
use Illuminate\Database\Eloquent\Model;


class Action
{
    protected $view = 'delete';
    public function __construct(
        public string $key,
        public string|null $method = null,
        public bool $confirm = false,
        public string|null $confirmTitle = null,
        public string|null $confirmText = null,
    ) {
        $this->method = $method ?? str()->camel("action_$this->key");
    }

    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }

    public function call(Table $table,Model $row){
        if (method_exists($table,$this->method)) {
            $table->{$this->method}($row);
        } else {
            throw new Exception("Method: $this->method not exists for your table. Create \"$this->method\" method for this action.");
        }
    }

    public function render(Model $item)
    {
        return view("livewire.datatables.actions.$this->view", [
            'item' => $item,
            'action' => $this,
        ])->render();
    }
}
