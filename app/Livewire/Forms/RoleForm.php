<?php

namespace App\Livewire\Forms;

use App\Enums\User\UserRightTypeEnum;
use App\Models\Role;
use App\Traits\FillModelFormTrait;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RoleForm extends Form
{
    use FillModelFormTrait;

    public $role;

    public $title = '';

    public $type = '';

    public $store_id = null;

    public $permissions = [];

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'type' => ['required'],
            'store_id' => ['nullable', 'exists:stores,id'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'exists:permissions,id'],
        ];
    }


    public function setStoreId($id = null)
    {
        $this->store_id = $id;

        if ($id) {
            $this->type = UserRightTypeEnum::Store;
        } else {
            $this->type = UserRightTypeEnum::Admin;
        }
    }

    public function init(Role $role)
    {
        $this->initForm($role, ['type', 'permissions.id', 'title',  'store_id'], 'role');
        $this->type = UserRightTypeEnum::Admin;
    }

    public function save()
    {
        $data = $this->validate();

        $this->exactFillModel(['title', 'type', 'store_id'], 'role');

        $this->role->save();

        $this->role->permissions()->sync($data['permissions']);
    }
}
