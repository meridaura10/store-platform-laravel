<form wire:submit='save'>
    <div class="p-6" x-data="{ isShowAddressModal: false, isShowProductModal: false }">
        <div x-show="isShowAddressModal"
            class="fixed top-0 left-0 right-0 bottom-0 z-50 overflow-hidden  bg-gray-800 bg-opacity-50 flex justify-center items-center">
            <!-- Modal container -->
            <div class="bg-white rounded-lg shadow-md w-full max-w-lg p-4">
                <!-- Modal header -->
                <div class="flex items-start justify-between border-b pb-2">
                    <h3 class="text-lg font-semibold text-gray-900">{{ trans('base.choose_your_city') }}
                    </h3>
                    <button type="button" @click="isShowAddressModal = false"
                        class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M14.293 5.293a1 1 0 011.414 0l.001.001c.39.391.39 1.023 0 1.414L11.414 10l4.294 4.293a1 1 0 11-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414 1 1 0 011.414 0L10 8.586l4.293-4.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="py-4 grid gap-3">
                    @livewire('client.components.form.area-search-select', [
                        'label' => 'Знайти область',
                        'event' => 'set-selected-area',
                        'eventUpdateDependes' => 'order-update-area-dependes',
                        'default' => isset($form->area['id']) ? $form->area['id'] : null,
                    ])

                    @include('livewire.ui.form.error', [
                        'model' => 'form.area',
                    ])
                    @if (isset($form->area))
                        @livewire('client.components.form.city-search-select', [
                            'label' => 'Знайти місто',
                            'event' => 'set-selected-city',
                            'eventUpdateDependes' => 'order-update-city-dependes',
                            'default' => isset($form->city['id']) ? $form->city['id'] : null,
                        ])
                        @include('livewire.ui.form.error', [
                            'model' => 'form.city',
                        ])
                    @endif
                    @if (isset($form->city))
                        @livewire('client.components.form.warehouse-search-select', [
                            'label' => 'Знайти відділення',
                            'event' => 'set-selected-warehouse',
                            'eventUpdateDependes' => 'order-update-warehouse-dependes',
                            'default' => isset($form->warehouse['id']) ? $form->warehouse['id'] : null,
                        ])
                        @include('livewire.ui.form.error', [
                            'model' => 'form.warehouse',
                        ])
                    @endif
                </div>
            </div>
        </div>
        <div x-show="isShowProductModal"
            class="fixed top-0 left-0 right-0 bottom-0 z-50 overflow-hidden  bg-gray-800 bg-opacity-50 flex justify-center items-center">
            <!-- Modal container -->
            <div class="bg-white rounded-lg shadow-md w-full max-w-lg p-4">
                <!-- Modal header -->
                <div class="flex items-start justify-between border-b pb-2">
                    <h3 class="text-lg font-semibold text-gray-900">{{ trans('base.choose_your_city') }}
                    </h3>
                    <button type="button" @click="isShowProductModal = false"
                        class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M14.293 5.293a1 1 0 011.414 0l.001.001c.39.391.39 1.023 0 1.414L11.414 10l4.294 4.293a1 1 0 11-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414 1 1 0 011.414 0L10 8.586l4.293-4.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div>
                    @livewire('store.components.form.product-search-select', [
                        'label' => 'знайдіть продукт',
                        'event' => 'set-selected-new-product',
                    ])
                </div>
            </div>
        </div>
        <div class="mb-4">
            @component('ui.card')
                <div class="grid grid-cols-2 gap-4">
                    @include('livewire.ui.form.input', [
                        'model' => 'form.customer.last_name',
                        'label' => trans('base.last_name'),
                        'styleLabelText' => 'text-[12px] text-[#797878]',
                    ])
                    @include('livewire.ui.form.input', [
                        'model' => 'form.customer.first_name',
                        'label' => trans('base.first_name'),
                        'styleLabelText' => 'text-[12px] text-[#797878]',
                    ])

                    @include('livewire.ui.form.input', [
                        'model' => 'form.customer.patronymics',
                        'label' => trans('base.patronymics'),
                        'styleLabelText' => 'text-[12px] text-[#797878]',
                    ])
                    @include('livewire.ui.form.input', [
                        'model' => 'form.customer.phone',
                        'label' => trans('base.phone'),
                        'type' => 'tel',
                        'styleLabelText' => 'text-[12px] text-[#797878]',
                    ])
                </div>
            @endcomponent
        </div>

        <div class="mb-4">
            @component('ui.card')
                <div>
                    <div class="py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="font-bold  text-xl">{{ trans('base.products') }} </h2>
                            </div>
                            <div>
                                @include('livewire.ui.form.error', [
                                    'model' => 'form.orderProducts',
                                ])
                            </div>
                            <div>
                                <div>
                                    <button type="button" @click='isShowProductModal = true' class="btn btn-primary">
                                        Додати продукт
                                    </button>
                                </div>
                            </div>
                        </div>
                        <ul>
                            @foreach ($form->orderProducts as $key => $orderProduct)
                                <li class="flex p-3 gap-2 items-center border-b">
                                    <div class="h-[70px] w-[70px]">
                                        @if (array_key_exists('product', $orderProduct))
                                            <img class="h-full object-cover"
                                                src="{{ $orderProduct['product']['image']['url'] }}" alt="">
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center w-full">
                                        <div>
                                            <div>
                                                {{ array_key_exists('id', $orderProduct) ? $orderProduct['title'] : $orderProduct['product']['title'] }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('id', $orderProduct) ? $orderProduct['price'] : $orderProduct['product']['price'] }}
                                                $
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div class="font-mono w-full max-w-[3]">
                                                <input class="input input-bordered" type="number" min="1"
                                                    max="{{ array_key_exists('product', $orderProduct) ? $orderProduct['product']['quantity'] : $orderProduct['quantity'] }}"
                                                    wire:model="form.orderProducts.{{ $key }}.quantity">
                                            </div>
                                            <button wire:click='removeProduct({{ $key }})' type="button"
                                                class="btn btn-error">Видалити продукт</button>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="py-4">
                        <div class="flex justify-between items-center">
                            <h2 class="font-bold  text-xl">{{ trans('base.payment') }}</h2>
                            <div>
                                @include('livewire.ui.form.error', [
                                    'model' => 'form.payment.type',
                                ])
                            </div>
                        </div>
                        <div>
                            <div class="my-2">
                                @include('livewire.ui.form.radio', [
                                    'model' => 'form.payment.type',
                                    'isLive' => true,
                                    'value' => App\Enums\Payment\PaymentTypeEnum::Cash,
                                    'label' => 'оплата при отрмані товару',
                                ])
                            </div>
                            <div>
                                @include('livewire.ui.form.radio', [
                                    'model' => 'form.payment.type',
                                    'isLive' => true,
                                    'value' => App\Enums\Payment\PaymentTypeEnum::Card,
                                    'label' => 'оплата зараз картой',
                                ])
                                @if ($form->payment['type'] === App\Enums\Payment\PaymentTypeEnum::Card->value)
                                    @include('livewire.ui.form.error', [
                                        'model' => 'form.payment.system',
                                    ])
                                    <ul class="grid gap-3 mt-2 ml-2">
                                        @include('livewire.ui.form.radio', [
                                            'model' => 'form.payment.system',
                                            'value' => App\Enums\Payment\PaymentSystemEnum::Fondy->name,
                                            'label' =>
                                                'оплата зарар через ' .
                                                App\Enums\Payment\PaymentSystemEnum::Fondy->value,
                                        ])
                                        @include('livewire.ui.form.radio', [
                                            'model' => 'form.payment.system',
                                            'value' => App\Enums\Payment\PaymentSystemEnum::LiqPay->name,
                                            'label' =>
                                                'оплата зарар через ' .
                                                App\Enums\Payment\PaymentSystemEnum::LiqPay->value,
                                        ])
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="py-4">
                        <div>
                            <h2 class="font-bold mb-2  text-xl">{{ trans('base.delivery') }} </h2>
                        </div>
                        <button @click="isShowAddressModal = true" type="button"
                            class="border p-4 flex justify-between items-center hover:bg-gray-100 transition-colors w-full">
                            <div class="flex gap-4 items-center">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30"
                                        height="30">
                                        <path
                                            d="M12 20.8995L16.9497 15.9497C19.6834 13.2161 19.6834 8.78392 16.9497 6.05025C14.2161 3.31658 9.78392 3.31658 7.05025 6.05025C4.31658 8.78392 4.31658 13.2161 7.05025 15.9497L12 20.8995ZM12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364L12 23.7279ZM12 13C13.1046 13 14 12.1046 14 11C14 9.89543 13.1046 9 12 9C10.8954 9 10 9.89543 10 11C10 12.1046 10.8954 13 12 13ZM12 15C9.79086 15 8 13.2091 8 11C8 8.79086 9.79086 7 12 7C14.2091 7 16 8.79086 16 11C16 13.2091 14.2091 15 12 15Z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <div class="flex items-center gap-3">
                                        <h3 class="font-bold">
                                            {{ $form->area['title'] ?? trans('base.y_area') }}
                                        </h3>
                                        <div>
                                            @include('livewire.ui.form.error', [
                                                'model' => 'form.area',
                                            ])
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <h3 class="font-medium">
                                            {{ $form->city['title'] ?? trans('base.city') }}
                                        </h3>
                                        <div>
                                            @include('livewire.ui.form.error', [
                                                'model' => 'form.city',
                                            ])
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <h3>
                                            {{ $form->warehouse['title'] ?? trans('base.warehouse') }}
                                        </h3>
                                        <div>
                                            @include('livewire.ui.form.error', [
                                                'model' => 'form.warehouse',
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('livewire.ui.form.buttonEdit')
                        </button>
                    </div>
                </div>
            @endcomponent
        </div>
        <div>
            @component('ui.card')
                <div>
                    <button class="btn btn-primary">
                        Зберегти
                    </button>
                </div>
            @endcomponent
        </div>
    </div>

</form>
