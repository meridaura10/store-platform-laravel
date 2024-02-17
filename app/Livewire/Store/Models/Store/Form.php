<?php

namespace App\Livewire\Store\Models\Store;

use App\Livewire\Forms\StoreForm;
use App\Models\Store;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;
    public StoreForm $form;

    public function mount(Store $store){
        $this->form->init($store);
    }

    public function save(){
        $this->form->save();
    }

    public function render()
    {
        return view('livewire.store.models.store.form');
    }
}
