<?php

namespace App\Livewire\Store\Models\Role;

use App\Livewire\Forms\RoleForm;
use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class Form extends Component
{
    public RoleForm $form;

    public $permissions = [];

    public function mount(Role $role)
    {
        $this->permissions = Permission::query()->get()->toArray();
        $this->form->init($role);
        $storeId = request()->route('store');
        $this->form->setStoreId($storeId);
    }

    public function save()
    {
        $this->form->save();

        redirect()->route('store.admin.role.index', [
            'store' => $this->form->store_id,
        ]);
    }

    public function render()
    {
        return view('livewire.store.models.role.form');
    }
}
