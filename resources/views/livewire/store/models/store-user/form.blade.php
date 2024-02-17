<form wire:submit='save'>
    <div class="mb-3">
        @component('ui.card')
            <h1 class="text-2xl font-bold">
                Форма {{ $form->storeUser->id ? 'редагування' : 'створення' }} персоналу
            </h1>
        @endComponent
    </div>
    <div class="mb-3">
        @component('ui.card')
            <div class="flex items-center gap-3">
                @livewire('store.components.form.user-search-select', [
                    'label' => 'знайти користувача',
                    'default' => $form->user_id,
                    'event' => 'store-user-form-user-selected',
                    'error' => $errors->first('form.user_id'),
                ])

                @include('livewire.ui.form.error', [
                    'model' => 'form.user_id',
                ])
            </div>
        @endComponent
    </div>
    <div class="mb-3">
        @component('ui.card')
            <div>
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <h4 class="text-lg font-semibold">
                            Ролі цього користувача
                        </h4>
                    </div>
                    @include('livewire.ui.form.error', [
                        'model' => 'form.roles',
                    ])
                    <div>
                        <a href="{{ route('store.admin.role.index', $form->store_id) }}">
                            <button type="button" class="btn btn-primary">
                                Управління ролями
                            </button>
                        </a>
                    </div>
                </div>
                <div class="space-y-2">
                    @foreach ($form->roleStoreUser as $role)
                        <div x-data="{ open: false }">
                            <div class="flex items-center gap-2">
                                <div @click="open = !open">
                                    <button type="button" class="btn btn-square btn-sm">
                                        <svg class="w-5 h-5x" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor">
                                            <path
                                                d="M12 6C12.8284 6 13.5 5.32843 13.5 4.5C13.5 3.67157 12.8284 3 12 3C11.1716 3 10.5 3.67157 10.5 4.5C10.5 5.32843 11.1716 6 12 6ZM9 10H11V18H9V20H15V18H13V8H9V10Z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="form-control w-full max-w-[300px]">
                                    <label class="label cursor-pointer">
                                        <span class="label-text">{{ $role['title'] }}</span>
                                        <input wire:model='form.roles' type="checkbox" value="{{ $role['id'] }}"
                                            class="checkbox" />
                                    </label>
                                </div>
                            </div>
                            <div class="p-2 border-l" x-show="open">
                                <ul>
                                    @foreach ($role['permissions'] as $permission)
                                        <li>
                                            {{ $permission['title'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endComponent
    </div>

    <div class="mb-3">
        @component('ui.card')
            <div class="flex justify-between items-center">
                <div>
                    @component('livewire.ui.form.button', ['type' => 'submit'])
                        Зберегти
                    @endcomponent
                </div>
                <div>
                    @include('livewire.ui.form.checkbox', [
                        'model' => 'form.status',
                    ])
                </div>
            </div>
        @endcomponent
    </div>
</form>
