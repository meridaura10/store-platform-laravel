<form wire:submit='save'>
    <div class="mb-3">
        @component('ui.card')
            <h1 class="text-2xl font-bold">
                Форма {{ $form->role->id ? 'редагування' : 'створення' }} ролі
            </h1>
        @endComponent
    </div>
    <div class="mb-3">
        @component('ui.card')
            @include('livewire.ui.form.input', [
                'model' => 'form.title',
            ])
        @endComponent
    </div>

    <div class="mb-3">
        @component('ui.card')
            <div class="grid grid-cols-2 items-center justify-between">
                @foreach ($permissions as $permission)
                    <div class="form-control max-w-[300px]">
                        <label class="label cursor-pointer">
                            <span class="label-text">{{ $permission['title'] }}</span>
                            <input wire:model='form.permissions' type="checkbox" value="{{ $permission['id'] }}" class="checkbox" />
                        </label>
                    </div>
                @endforeach
            </div>
        @endcomponent
    </div>

    <div class="mb-3">
        @component('ui.card')
            <div class="flex justify-between items-center">
                <div>
                    @component('livewire.ui.form.button', ['type' => 'submit'])
                        Зберегти
                    @endcomponent
                </div>
            </div>
            <div>
                @if ($errors->any())
                    <div class="mt-4">
                        @component('ui.card')
                            <div class="text-red-500">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endcomponent
                    </div>
                @endif
            </div>
        @endcomponent
    </div>
</form>
