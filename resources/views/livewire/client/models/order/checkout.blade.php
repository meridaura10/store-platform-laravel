<div>
    <form wire:submit='checkout'>
        <div class="w-full max-w-[1232px] mx-auto">
            <div class="py-5">
                <h1 class="font-bold text-[32px] text-black">
                    {{ trans('base.placing_order') }}
                </h1>
            </div>


            <div class="pb-4">
                <div>
                    <h2 class="font-bold  text-xl">{{ trans('base.recipient_order') }}</h2>
                </div>
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
                <div class="p-4 mt-4 bg-[rgba(255,169,0,.1)]  border border-[#ffa900] rounded-md">
                    {{ trans('base.orders_text') }}
                </div>
            </div>

            <div>
                @foreach ($form->orders as $key => $order)
                    <div wire:key='order-{{ $key }}-item' x-data="{ isOpen: false }">
                        <div x-show="isOpen"
                            class="fixed top-0 left-0 right-0 bottom-0 z-50 overflow-hidden  bg-gray-800 bg-opacity-50 flex justify-center items-center">
                            <!-- Modal container -->
                            <div class="bg-white rounded-lg shadow-md w-full max-w-lg p-4">
                                <!-- Modal header -->
                                <div class="flex items-start justify-between border-b pb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ trans('base.choose_your_city') }}
                                    </h3>
                                    <button type="button" @click="isOpen = false"
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
                                    @livewire(
                                        'client.components.form.area-search-select',
                                        [
                                            'label' => 'Знайти область',
                                            'event' => 'set-selected-area',
                                            'prefix' => $key,
                                            'eventUpdateDependes' => "order-$key-update-area-dependes",
                                        ],
                                        key("order-$key-area")
                                    )

                                    @include('livewire.ui.form.error', [
                                        'model' => "form.orders.$key.address.area",
                                    ])
                                    @if (isset($form->orders[$key]['address']['area']))
                                        @livewire(
                                            'client.components.form.city-search-select',
                                            [
                                                'label' => 'Знайти місто',
                                                'event' => 'set-selected-city',
                                                'eventUpdateDependes' => "order-$key-update-city-dependes",
                                                'prefix' => $key,
                                            ],
                                            key("order-$key-city")
                                        )
                                        @include('livewire.ui.form.error', [
                                            'model' => "form.orders.$key.address.city",
                                        ])
                                    @endif
                                    @if (isset($form->orders[$key]['address']['city']))
                                        @livewire(
                                            'client.components.form.warehouse-search-select',
                                            [
                                                'label' => 'Знайти відділення',
                                                'event' => 'set-selected-warehouse',
                                                'eventUpdateDependes' => "order-$key-update-warehouse-dependes",
                                                'prefix' => $key,
                                            ],
                                            key("order-$key-warehouse")
                                        )
                                        @include('livewire.ui.form.error', [
                                            'model' => "form.orders.$key.address.warehouse",
                                        ])
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-8">
                            <div class="my-3">
                                <h2 class="font-bold text-3xl">Замовлення
                                    №{{ array_search($key, array_keys($form->orders)) + 1 }}</h2>
                            </div>
                            <div class="px-8">
                                <div class="py-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h2 class="font-bold  text-xl">{{ trans('base.products') }} </h2>
                                        </div>
                                        <div>
                                            <a href="{{ route('basket.index') }}">
                                                @include('livewire.ui.form.buttonEdit')
                                            </a>
                                        </div>
                                    </div>
                                    <ul>
                                        @foreach ($order['basketProducts'] as $basketItem)
                                            <li class="flex p-3 gap-2 items-center border-b">
                                                <div class="h-[70px] w-[70px]">
                                                    <img class="h-full object-cover"
                                                        src="{{ $basketItem['product']['image']['url'] }}"
                                                        alt="">
                                                </div>
                                                <div class="flex justify-between items-center  w-full">
                                                    <div>
                                                        {{ $basketItem['product']['title'] }}
                                                    </div>
                                                    <div class="font-mono">
                                                        {{ $basketItem['product']['price'] }} $ x
                                                        {{ $basketItem['quantity'] }}
                                                        {{ trans('base.item') }}.
                                                    </div>
                                                    <div class="font-bold text-base">
                                                        {{ $basketItem['sum'] }} $
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
                                                'model' => "form.orders.$key.payment.type",
                                            ])
                                        </div>
                                    </div>
                                    <div>
                                        <div class="my-2">
                                            @include('livewire.ui.form.radio', [
                                                'model' => "form.orders.$key.payment.type",
                                                'isLive' => true,
                                                'value' => App\Enums\Payment\PaymentTypeEnum::Cash,
                                                'label' => 'оплата при отрмані товару',
                                            ])
                                        </div>
                                        <div>
                                            @include('livewire.ui.form.radio', [
                                                'model' => "form.orders.$key.payment.type",
                                                'isLive' => true,
                                                'value' => App\Enums\Payment\PaymentTypeEnum::Card,
                                                'label' => 'оплата зараз картой',
                                            ])
                                            @if ($order['payment']['type'] === App\Enums\Payment\PaymentTypeEnum::Card->value)
                                                @include('livewire.ui.form.error', [
                                                    'model' => "form.orders.$key.payment.system",
                                                ])
                                                <ul class="grid gap-3 mt-2 ml-2">
                                                    @include('livewire.ui.form.radio', [
                                                        'model' => "form.orders.$key.payment.system",
                                                        'value' =>
                                                            App\Enums\Payment\PaymentSystemEnum::Fondy->name,
                                                        'label' =>
                                                            'оплата зарар через ' .
                                                            App\Enums\Payment\PaymentSystemEnum::Fondy->value,
                                                    ])
                                                    @include('livewire.ui.form.radio', [
                                                        'model' => "form.orders.$key.payment.system",
                                                        'value' =>
                                                            App\Enums\Payment\PaymentSystemEnum::LiqPay->name,
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
                                    <button @click="isOpen = true" type="button"
                                        class="border p-4 flex justify-between items-center hover:bg-gray-100 transition-colors w-full">
                                        <div class="flex gap-4 items-center">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    width="30" height="30">
                                                    <path
                                                        d="M12 20.8995L16.9497 15.9497C19.6834 13.2161 19.6834 8.78392 16.9497 6.05025C14.2161 3.31658 9.78392 3.31658 7.05025 6.05025C4.31658 8.78392 4.31658 13.2161 7.05025 15.9497L12 20.8995ZM12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364L12 23.7279ZM12 13C13.1046 13 14 12.1046 14 11C14 9.89543 13.1046 9 12 9C10.8954 9 10 9.89543 10 11C10 12.1046 10.8954 13 12 13ZM12 15C9.79086 15 8 13.2091 8 11C8 8.79086 9.79086 7 12 7C14.2091 7 16 8.79086 16 11C16 13.2091 14.2091 15 12 15Z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="text-left">
                                                <div class="flex items-center gap-3">
                                                    <h3 class="font-bold">
                                                        {{ $form->orders[$key]['address']['area']['title'] ?? trans('base.y_area') }}
                                                    </h3>
                                                    <div>
                                                        @include('livewire.ui.form.error', [
                                                            'model' => "form.orders.$key.address.area",
                                                        ])
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <h3 class="font-medium">
                                                        {{ $form->orders[$key]['address']['city']['title'] ?? trans('base.city') }}
                                                    </h3>
                                                    <div>
                                                        @include('livewire.ui.form.error', [
                                                                   'model' => "form.orders.$key.address.city",
                                                        ])
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <h3>
                                                        {{ $form->orders[$key]['address']['warehouse']['title'] ?? trans('base.warehouse') }}
                                                    </h3>
                                                    <div>
                                                        @include('livewire.ui.form.error', [
                                                                   'model' => "form.orders.$key.address.warehouse",
                                                        ])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @include('livewire.ui.form.buttonEdit')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-5 bg-gray-100 rounded-lg">
                <div class="">
                    <div class=" pb-4 border-b border-gray-300">
                        <h3 class="text-2xl mb-4 font-bold text-black">{{ trans('base.together') }}</h3>
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-gray-600">
                                {{ basket()->totalQuantity() }} {{ trans('base.products') }}:
                            </h2>
                            <span class="font-mono">
                                {{ basket()->totalSum() }} $
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <h2 class="text-gray-600">
                                {{ trans('base.delivery') }}:
                            </h2>
                            <span class="">
                                {{ trans('base.free') }}
                            </span>
                        </div>
                        <div>

                        </div>
                    </div>
                    <div class="flex py-4 border-b border-gray-300 mb-4 items-center justify-between">
                        <h2 class="text-gray-600">
                            {{ trans('base.to_be_paid') }}:
                        </h2>
                        <span class="font-bold text-2xl font-mono">
                            {{ basket()->totalSum() }} $
                        </span>
                    </div>
                    <button type="submit" wire:loading.class='opacity-50'
                        class="focus:outline-none w-full text-white bg-green-600 hover:bg-green-500 text-lg transition-all focus:ring-4 focus:ring-green-300 font-medium rounded-lg px-5 py-2.5 mr-2 mb-2 ">
                        {{ trans('base.confirm_order') }}
                    </button>
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
        </div>
    </form>
</div>
