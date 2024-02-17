<?php

namespace App\Livewire\Datatables\Utils;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalEditField extends Component
{
    public bool $open = false;
    public string $model = '';
    public string $field = '';
    public string $title = '';
    public array $values = [];
    public string $description  = '';
    public $item;

    #[On('modal-edit-field-open')]
    public function open($data)
    {
        $this->values =  $data['values'];
        $this->title =  $data['title'];
        $this->field =  $data['field'];
        $this->model =  $data['model'];
        $this->item =  $data['item'];
        $this->description = array_key_exists('description', $data) ? $data['description'] : '';

        $this->open = true;
    }

    public function save($value)
    {
        $this->open = false;
        $item = $this->model::query()->where('id', $this->item['id'])->first();

        $relations = explode('.', $this->field);
        $field = array_pop($relations);

        if ($relations) {
            foreach ($relations as $rel) {
                $item = $item->{$rel};
            }
        }

        $item->update([
            $field => $value,
        ]);


        $this->dispatch('refresh-table');
    }

    public function value()
    {
        $keys = explode('.', $this->field);
        $value = $this->item;

        foreach ($keys as $key) {
            $value = $value[$key];
        }

        return $value;
    }

    public function render()
    {
        return view('livewire.datatables.utils.modal-edit-field');
    }
}
