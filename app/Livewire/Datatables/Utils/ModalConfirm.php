<?php

namespace App\Livewire\Datatables\Utils;

use Livewire\Attributes\On;
use Livewire\Component;

class ModalConfirm extends Component
{
    public bool $open;
    public string $title;
    public string $description;
    public string $event;
    public array $params;
    
    #[On('modal-confirm-open')] 
    public function openModal($title, $description, $event, $params)
    {
        $this->title = $title;
        $this->description = $description;
        $this->event = $event;
        $this->params = $params;

        $this->open = true;
    }

    public function confirmed()
    {
        $this->dispatch($this->event, $this->params);

        $this->open = false;
    }

    public function render()
    {
        return view('livewire.datatables.utils.modal-confirm');
    }
}
