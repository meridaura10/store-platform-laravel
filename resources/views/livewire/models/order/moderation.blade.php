<div class="p-6 space-y-4">
    @component('ui.card')
        <div class="font-bold text-lg mb-2">Замовлення</div>
        <div>Id: {{ $order->id }}</div>
        <div>Ціна: {{ $order->amount }}</div>
        <div>Статус: {{ $order->status }}</div>
        <div>Магазин: {{ $order->store->title }}</div>
    @endcomponent
    @component('ui.card')
        <div class="font-bold text-lg mb-2">Клієнт</div>
        <div>Телефон: {{ $order->customer->phone }}</div>
        <div>Ім'я: {{ $order->customer->first_name }}</div>
        <div>Прізвище: {{ $order->customer->last_name }}</div>
        <div>По батькові: {{ $order->customer->patronymics }}</div>
    @endcomponent
    @component('ui.card')
        <div class="font-bold text-lg mb-2">Доставка</div>
        <div>Місто: {{ $order->warehouse->city->title }}</div>
        <div>Область: {{ $order->warehouse->city->area->title }}</div>
        <div>Відділення: {{ $order->warehouse->title }}</div>
    @endcomponent
    @component('ui.card')
        <div class="font-bold text-lg mb-2">Оплата</div>
        <div>Тип: {{ $order->payment->type }}</div>
        <div>Система: {{ $order->payment->system }}</div>
        <div>Статус: {{ $order->payment->status }}</div>
    @endcomponent
    @component('ui.card')
        <div class="font-bold text-lg mb-2">Продукти</div>
        <ul>
            @foreach ($order->orderProducts as $orderProduct)
                <li class="flex p-3 gap-2 items-center border-b">
                    <div class="h-[70px] w-[70px]">
                        <img class="h-full object-cover" src="{{ $orderProduct->product->image->url }}" alt="">
                    </div>
                    <div class="flex justify-between items-center  w-full">
                        <div>
                            {{ $orderProduct->title }}
                        </div>
                        <div class="font-mono">
                            {{ $orderProduct->price }} $ x
                            {{ $orderProduct->quantity }}
                            {{ trans('base.item') }}.
                        </div>
                        <div class="font-bold text-base">
                            {{ $orderProduct->sum }} $
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endcomponent

    @component('ui.card')
        <div class="flex justify-between">
            <div>
                <select class="select select-bordered" wire:model.live="selectedStatusModeration">
                    @foreach ($moderationStatuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <span class="text-lg font-semibold">нинішній статус модерації:</span> <span
                    class="text-xl font-bold">{{ $order->moderation->status }}</span>
            </div>
        </div>
    @endcomponent

    @component('ui.card')
        <div class="flex justify-between">
            <div>
                <select class="select select-bordered" wire:model.live="selectedStatusOrder">
                    @foreach ($orderStatuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <span class="text-lg font-semibold">нинішній статус замовлення:</span> <span
                    class="text-xl font-bold">{{ $order->status }}</span>
            </div>
        </div>
    @endcomponent

</div>
