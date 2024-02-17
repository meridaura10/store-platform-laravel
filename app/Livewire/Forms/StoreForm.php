<?php

namespace App\Livewire\Forms;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Enums\Store\StoreStatusEnum;
use App\Enums\Store\StoreStatuses;
use App\Enums\User\UserRightTypeEnum;
use App\Enums\User\UserStoreRoleEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Store;
use App\Models\StoreUser;
use App\Traits\FillModelFormTrait;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class StoreForm extends Form
{
    use FillModelFormTrait, WithFileUploads;

    public Store $store;

    public $image;

    public $newImage;

    public $translations;

    public function rules()
    {
        $rules = [];

        foreach (localization()->getSupportedLocalesKeys() as $lang) {
            $defaultRule = $lang == localization()->getDefaultLocale()  ? 'required' : 'nullable';
            $rules["translations.$lang.title"] = [$defaultRule, 'string', 'max:190'];
            $rules["translations.$lang.description"] = [$defaultRule, 'string', 'max:480'];
        }

        if ($this->image) {
            $rules['newImage'] = ['nullable'];
        } else {
            $rules['newImage'] = ['required'];
        }

        return $rules;
    }

    public function init(Store $store)
    {
        $this->initForm($store, ['image'], 'store');

        $this->translations = $store->getTranslationsArray();
    }

    public function save()
    {
        $this->validate();

        $this->store->status = 1;

        if ($this->store->id) {
            $this->store->moderation()->update(['status' => ModerationStatusesEnum::Recheck, 'reason' => 'було внесено зміни']);
            $this->store->save();
        } else {

            $this->store->save();

            $admin = Role::create([
                'title' => 'owner',
                'type' => UserRightTypeEnum::Store,
                'store_id' => $this->store->id
            ]);

            $permissions = Permission::where('type', UserRightTypeEnum::Store)->get(['id']);
            $admin->permissions()->sync($permissions);

            StoreUser::create([
                'store_id' => $this->store->id,
                'user_id' => auth()->id(),
                'status' => true,
            ])
                ->roles()
                ->sync($admin);

            $this->store->moderation()->create(['status' => ModerationStatusesEnum::Now]);
        }


        $this->store->save();

        if ($this->newImage) {
            $this->store->image()->delete();

            $path = $this->newImage->store("stores");

            $this->store->image()->create([
                'order' => 0,
                'path' => $path,
                'disk' => 'local',
            ]);
        }

        $this->store->update($this->translations);
    }
}
