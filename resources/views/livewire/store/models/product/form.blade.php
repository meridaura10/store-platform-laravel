<form wire:submit='save'>
    <div class="mb-3">
        @component('ui.card')
            <h1 class="text-2xl font-bold">
                Форма {{ $form->product->id ? 'редагування' : 'створення' }} продукту
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
            @include('livewire.ui.form.translations', [
                'fields' => [
                    [
                        'type' => 'textarea',
                        'name' => 'description',
                    ],
                ],
            ])

            <div class="mt-3">
                @include('livewire.ui.form.input', [
                    'type' => 'number',
                    'model' => 'form.price',
                    'label' => 'ціна',
                ])
            </div>

            <div class="mt-3">
                @include('livewire.ui.form.input', [
                    'type' => 'number',
                    'model' => 'form.quantity',
                    'label' => 'кількість',
                ])
            </div>
        @endComponent
    </div>

    <div class="mb-3">
        @component('ui.card')
            @include('livewire.store.models.category.tree.index', ['categories' => $categories])
        @endComponent
    </div>

    <div class="mb-3">
        @component('ui.card')
            <div class="">
                <div>

                </div>
                <div class="flex mt-4 flex-wrap gap-5">
                    @if (isset($form->product->id))
                        @foreach ($form->images as $key => $image)
                            <div wire:key='{{ $image['id'] }}.image' class="w-48 relative">
                                <div class="h-48 flex justify-center">
                                    <img class="object-contain max-h-48" src="{{ $image['url'] }}" alt="">
                                </div>
                                <button type="button" wire:click="removeImage({{ $key }}, true)"
                                    class="absolute top-0 bg-white pl-2 pb-2 rounded-bl-full border-t border-r hover:bg-gray-300 transition-all right-0 text-red-500 hover:text-red-700 cursor-pointer">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                                <div class="mt-2">
                                    @include('livewire.ui.form.input', [
                                        'model' => "form.images.$key.order",
                                        'placeholder' => 'order',
                                        'type' => 'number',
                                    ])
                                
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if (count($form->newImages))
                        @foreach ($form->newImages['images'] as $key => $image)
                            <div class="w-48 relative" wire:key="{{ $key }}.newImages.{{ $key }}"
                                class="relative">
                                <div class="h-48 flex justify-center">
                                    <img class="object-contain max-h-48" src="{{ $image->temporaryUrl() }}" alt="">
                                </div>
                                <button type="button" wire:click="removeImage({{ $key }},false)"
                                    class="absolute top-0 bg-white pl-2 pb-2 rounded-bl-full border-t border-r hover:bg-gray-300 transition-all right-0 text-red-500 hover:text-red-700 cursor-pointer">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                                <div class="mt-2">
                                    @include('livewire.ui.form.input', [
                                        'model' => "form.newImages.orders.$key",
                                        'placeholder' => 'order',
                                        'type' => 'number',
                                    ])

                                </div>
                            </div>
                        @endforeach
                    @endif


                </div>
                <div class="mt-2">
                    @include('livewire.ui.form.file', [
                        'model' => 'form.newImages.images',
                        'multiply' => true,
                    ])
                </div>
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
                <div>
                    @include('livewire.ui.form.checkbox', [
                        'model' => 'form.status',
                    ])
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
