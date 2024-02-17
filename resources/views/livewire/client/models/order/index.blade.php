<section class="p-6 w-full">
    @if (!$hasOrders)
        <div class="text-center pt-5">
            <img class="mx-auto" _ngcontent-rz-client-c1691351868="" alt="" loading="lazy" width="300px"
                src="https://xl-static.rozetka.com.ua/assets/img/design/cabinet/cabinet-orders-dummy.svg">
            <h2 class="font-bold text-xl">{{ trans('base.the_list_orders_empty') }}</h2>
            <p class="text-gray-500 mb-4">{{ trans('base.you_haven`t_ordered_anything_yet') }}</p>
            <div class="pt-2">
                <a class="py-3 px-4  bg-green-600 rounded-lg hover:bg-green-500 text-white transition-colors"
                    href="{{ route('client.index') }}">
                    {{ trans('base.go_main_page') }}
                </a>
            </div>
        </div>
    @else
        @component('ui.card')
            <div>
                <div class="mb-4 flex justify-between items-center">
                    <h1 class="text-2xl  text-black font-bold">{{ trans('base.my_orders') }}</h1>
                    <button @if (!$this->hasFilter()) disabled @endif class="btn" wire:click="clearFilter">
                        скинути фільтри
                    </button>
                </div>
                <div class="flex justify-between items-center gap-2 flex-wrap">
                    <div>
                        @if ($this->hasTabs())
                            <ul
                                class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400  mt-3 gap-2  rounded-lg">
                                @foreach ($tabs as $tab)
                                    <li wire:click="selectTab('{{ $tab->key }}')" class="cursor-pointer">
                                        <div
                                            class="inline-block px-4 py-3 text-white  rounded-lg @if ($this->tabActive($tab)) bg-blue-600 @else bg-blue-300 @endIf">
                                            {{ $tab->title }}
                                        </div>
                                    </li>
                                @endforeach
                                <li wire:click="selectTab()" class="cursor-pointer">
                                    <div
                                        class="inline-block px-4 py-3 text-white rounded-lg @if (!$this->hasSelectedTab()) bg-blue-600 @else bg-blue-300 @endIf">
                                        Всі
                                    </div>
                                </li>
                            </ul>
                        @endif
                    </div>
                    <div class="w-[300px]">
                        <select wire:model.live='sort'
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500  focus:border-blue-500 block w-full p-2.5">
                            <option disabled selected value="null">{{ trans('base.sorting') }}</option>
                            @foreach ($sorts as $sort)
                                {!! $sort->render() !!}
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    @if ($this->hasFilters())
                        <div class="flex gap-2 mt-4 items-center">
                            @foreach ($filters as $filter)
                                <div>
                                    {!! $filter->render() !!}
                                </div>
                            @endforeach
                        </div>
                    @endIf
                </div>

            </div>
        @endcomponent


        <div class="w-full mt-2">
            @if ($orders->isEmpty())
                <div class="text-center">
                    <p class="text-gray-500 text-xl font-semibold pt-4">
                        {{ trans('base.no_orders_were_found_for_the_selected_filters') }} </p>
                </div>
            @else
                <ul class="grid gap-4 ">
                    @foreach ($orders as $order)
                        <li wire:key='{{ $order->id }}' class="bg-white shadow-lg rounded-lg p-6 relative">
                            <div class="flex justify-between">
                                <div>
                                    <h2 class="text-xl font-semibold mb-2">{{ trans('base.order') }}
                                        #{{ $order->id }}</h2>
                                </div>
                                <div>
                                    <p class="text-gray-700">{{ trans('base.date_creation') }}: <span
                                            class="font-bold">{{ $order->created_at->format('d.m.Y H:i') }}</span></p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-700">{{ trans('statuses.status') }}: <span class="font-bold">
                                            {{ trans('statuses.' . $order->status->value) }} </span></p>
                                    <p class="text-gray-700">{{ trans('statuses.status_payment') }}: <span
                                            class="font-bold">{{ trans('statuses.' . $order->payment->status->value) }}</span>
                                    </p>
                                </div>
                                @if ($order->payment->status !== App\Enums\Payment\PaymentStatusEnum::Completed)
                                    @switch($order->payment->type)
                                        @case(App\Enums\Payment\PaymentTypeEnum::Cash)
                                            <div class="font-bold text-lg">
                                                <span>Оплата при отримані товару</span>
                                            </div>
                                        @break

                                        @case(App\Enums\Payment\PaymentTypeEnum::Card)
                                            @if ($this->isPaymentExpired($order->payment))
                                                <div class="font-bold text-lg">
                                                    <span>Час оплати закінчився</span>
                                                </div>
                                            @else
                                                <button wire:click='pay({{ $order }})' class="btn btn-primary">
                                                    Оплатити Зараз
                                                </button>
                                            @endif
                                        @break

                                        @default
                                    @endswitch
                                @endIf


                            </div>
                            <div class="mt-4 ">
                                <div>
                                    <h5 class="font-bold text-lg mb-2">{{ trans('base.products') }}</h5>
                                </div>
                                <ul class="grid grid-cols-2 justify-between gap-3">
                                    @foreach ($order->orderProducts as $orderProduct)
                                        <li class="flex items-center w-full max-w-[500px] space-x-4">
                                            <img src="{{ $orderProduct->product ? $orderProduct->product->image->url : '' }}"
                                                alt="{{ $orderProduct->product->title }}"
                                                class="w-16 h-16 object-cover rounded-md">
                                            <div>
                                                <p class="font-semibold">{{ $orderProduct->title }}</p>
                                                <p class="text-gray-700">{{ $orderProduct->price }}
                                                    {{ trans('base.uah') }}
                                                </p>
                                                <p class="text-gray-700">{{ $orderProduct->quantity }}
                                                    {{ trans('base.item') }}.</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mt-2">
                                <div>
                                    <p class="text-lg font-semibold text-blue-500">{{ trans('base.total_price') }}:
                                        {{ $order->amount }}
                                        {{ trans('base.uah') }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

</section>
