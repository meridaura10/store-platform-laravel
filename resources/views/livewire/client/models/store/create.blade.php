<form wire:submit='save' class="p-6">
    <div class="mb-3">
        @component('ui.card')
            <h1 class="text-2xl font-bold">
                Форма {{ $form->store->id ? 'редагування' : 'створення' }} магазину
            </h1>
        @endComponent
    </div>
    <div class="mb-3">
        @component('ui.card')
            @include('livewire.ui.form.translations', [
                'fields' => [
                    [
                        'type' => 'input',
                        'name' => 'title',
                    ],
                ],
            ])
            <div class="mt-2">
                <div class="mb-2">
                    <div class="w-48">
                        @if ($form->newImage)
                            <img class="w-full object-contain rounded-lg" src="{{ $form->newImage->temporaryUrl() }}" alt="logo">
                        @else
                            @if ($form->image && array_key_exists('id', $form->image))
                                <img class="w-full rounded-lg" src="{{ $form->image['url'] }}" alt="logo">
                            @else
                                <div class="w-full h-48 text-center flex flex-col justify-center border-2 rounded-lg">
                                    <span class="font-semibold">
                                        Ще не має логотипу
                                    </span>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                @include('livewire.ui.form.file', [
                    'model' => 'form.newImage',
                    'multiple' => false,
                    'label' => 'Логотип магазину',
                ])
            </div>
        @endcomponent
    </div>
    <div class="mb-3">
        @component('ui.card')
            @include('livewire.ui.form.translations', [
                'fields' => [
                    [
                        'type' => 'textarea',
                        'name' => 'description',
                    ],
                ],
            ])
        @endcomponent
    </div>

    <div class="mb-3">
        @component('ui.card')
            @component('livewire.ui.form.button', ['type' => 'submit'])
                Зберегти
            @endcomponent
        @endcomponent
    </div>

</form>
