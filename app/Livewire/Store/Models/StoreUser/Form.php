<?php

namespace App\Livewire\Store\Models\StoreUser;

use App\Enums\User\UserStoreRoleEnum;
use App\Livewire\Forms\StoreUserForm;
use App\Models\StoreUser;
use Livewire\Attributes\On;
use Livewire\Component;

class Form extends Component
{
    public StoreUserForm $form;

    public function mount(StoreUser $storeUser)
    {
        $this->form->init($storeUser);
    }

    #[On('store-user-form-user-selected')] 
    public function updateUser($user)
    {
        $this->form->setUserId($user['id']);
    }

    public function save()
    {
        $this->form->save();

        redirect()->route('store.admin.staff.index', [
            'store' => $this->form->store_id,
        ]);
    }

    public function render()
    {
        return view('livewire.store.models.store-user.form');
    }
}
