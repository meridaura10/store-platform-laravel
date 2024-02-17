<?php

namespace App\Livewire\Forms;

use App\Enums\User\UserRightTypeEnum;
use App\Enums\User\UserStoreRoleEnum;
use App\Models\Role;
use App\Models\Store;
use App\Models\StoreUser;
use App\Traits\FillModelFormTrait;
use Livewire\Form;

class StoreUserForm extends Form
{
    use FillModelFormTrait;

    public StoreUser $storeUser;

    public array $roles = [];

    public $roleStoreUser;

    public ?int $user_id = null;

    public ?int $store_id = null;

    public bool $status = true;

    public function rules()
    {
        return  [
            'status' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
            'store_id' => 'required|exists:stores,id',
            'roles' => 'array|required',
            'roles.*' => 'required|exists:roles,id',
        ];
    }

    public function init(StoreUser $storeUser): void
    {
        $this->initForm($storeUser, ['status', 'user_id'], 'storeUser');
        
        $this->store_id = request()->route('store');

        $store = Store::find($this->store_id);

        $this->roleStoreUser = $store->roles;

        $this->roles = $storeUser->roles()->get()->pluck('id')->toArray();
    }

    public function setUserId(?int $id = null)
    {
        $this->user_id = $id;
    }

    public function save(): void
    {
        $this->validate();

        $this->exactFillModel(['status', 'user_id', 'store_id'], 'storeUser');

        $this->storeUser->save();

        $this->storeUser->roles()->sync($this->roles);
    }
}
