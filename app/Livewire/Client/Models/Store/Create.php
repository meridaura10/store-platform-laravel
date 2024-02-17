<?php

namespace App\Livewire\Client\Models\Store;


use App\Livewire\Forms\StoreForm;
use App\Models\Store;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public StoreForm $form;

    public function mount(Store $store){
        $this->form->init($store);
    }

    public function save(){
        $this->form->save();

        redirect()->route('user.cabinet.store.index');
    }

    public function render()
    {
        return view('livewire.client.models.store.create');
    }
}
