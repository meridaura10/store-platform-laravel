<?php

namespace App\Livewire\Client\Models\StoreUser;

use Livewire\Component;

class Index extends Component
{
    private $userStores;

    public function mount()
    {
        $this->userStores = auth()
            ->user()
            ->storeUsers()
            ->with(['store.translations', 'store.image', 'roles', 'store.moderation'])
            ->get();
    }

    public function render()
    {
        return view('livewire.client.models.store-user.index', [
            'userStores' => $this->userStores,
        ]);
    }
}
