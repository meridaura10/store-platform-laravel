<div>
    <div>
        <div>
            @if ($this->contentHeader())
                {!! $this->contentHeader()->render() !!}
            @endIf
        </div>
        <div class="border-b py-4 flex justify-between gap-8 items-end">
            <div class="flex w-full items-center">
                <div>
                    @if ($this->hasFilter())

                        <ul class="flex flex-wrap items-center">
                            <button type="button" wire:click="clearFilter"
                                class="py-1.5 px-3 mr-2 mb-2 text-sm font-medium text-gray-500 transition-all  bg-white rounded-full border border-red-300 hover:bg-red-300 hover:text-white">{{ trans('base.Cancel ') }}</button>
                            @foreach ($f as $key => $values)
                                @switch($filters->filter($key)->type())
                                    @case('text')
                                        @if ($values)
                                            <li>
                                                <button type="button" wire:click='clearFilter("{{ $key }}")'
                                                    class="py-1.5 px-3 flex items-center mr-2 mb-2 text-sm font-medium text-gray-500 transition-all  bg-white rounded-full border border-gray-300 hover:bg-gray-100">
                                                    {{ $values }}
                                                    <span><i class="ri-close-line text-gray-400 text-lg"></i></span>
                                                </button>
                                            </li>
                                        @endIf
                                    @break

                                    @case('range')
                                        <li>
                                            <button type="button" wire:click='clearFilter("{{ $key }}")'
                                                class="py-1.5 px-3 flex items-center mr-2 mb-2 text-sm font-medium text-gray-500 transition-all  bg-white rounded-full border border-gray-300 hover:bg-gray-100">
                                                {{ $values['min'] ?? $filters->filter($key)->attributes['min'] }} -
                                                {{ $values['max'] ?? $filters->filter($key)->attributes['max'] }}
                                                {{ trans('base.uah') }}
                                                <span><i class="ri-close-line text-gray-400 text-lg"></i></span>
                                            </button>
                                        </li>
                                    @break

                                    @case('check-box')
                                        @foreach ($values as $keyValue => $value)
                                            <li>
                                                <button type="button"
                                                    wire:click='clearFilter("{{ $key }}","{{ $keyValue }}")'
                                                    class="py-1.5 px-3 flex items-center mr-2 mb-2 text-sm font-medium text-gray-500 transition-all  bg-white rounded-full border border-gray-300 hover:bg-gray-100">
                                                    {{ $filters->filter($key)->getValues()[$value] }}
                                                    <span><i class="ri-close-line text-gray-400 text-lg"></i></span>
                                                </button>
                                            </li>
                                        @endforeach
                                    @break

                                    @case('categories')
                                        @foreach ($values as $keyValue => $value)
                                            <li>
                                                <button type="button"
                                                    wire:click='clearFilter("{{ $key }}","{{ $keyValue }}")'
                                                    class="py-1.5 px-3 flex items-center mr-2 mb-2 text-sm font-medium text-gray-500 transition-all  bg-white rounded-full border border-gray-300 hover:bg-gray-100">
                                                    {{ $filters->filter($key)->values[$value][0]['parentName'] }}
                                                    <span><i class="ri-close-line text-gray-400 text-lg"></i></span>
                                                </button>
                                            </li>
                                        @endforeach
                                    @break
                                @endswitch
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="w-[300px]">
                <select wire:model.live='sort'
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500  focus:border-blue-500 block w-full p-2.5">
                    <option disabled selected value="null">{{ trans('base.sorting') }}</option>
                    @foreach ($sorts as $sort)
                        {!! $sort->render($this) !!}
                    @endforeach
                </select>

            </div>
        </div>
    </div>
    <div class="flex flex-col  lg:flex-row ">

        <div class="max-w-[300px] overflow-hidden w-[300px] border-r">
            <ul>
                @if ($this->hasFilters())
                    @foreach ($filters as $key => $filter)
                        <li class="@if ($key > 0) border-t @endIf  pr-3 pl-2">
                            <div x-data="{ open: true }" class="w-full py-2">
                                <div class="w-full hover:text-red-400  text-blue-600 ">
                                    <div x-on:click="open = ! open"
                                        class="flex justify-between items-center cursor-pointer">
                                        <h2 class="text-sm py-1 transition-colors">{{ $filter->title }}
                                            <span class="text-gray-400 text-sm pl-1"></span>
                                        </h2>
                                        <i x-bind:class="open ? 'ri-arrow-down-s-line' : 'ri-arrow-up-s-line'"
                                            class="text-2xl text-gray-500"></i>
                                    </div>
                                </div>
                                <div x-show="open" x-transition>
                                    {!! $filter->render($this) !!}
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endIf
            </ul>
        </div>
        <main class="w-full">
            <ul class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5">
                @foreach ($products as $product)
                    <li class="relative group transition-all">
                        <div class="border-b border-r product">
                            <div>
                                <div class="w-full h-48 relative">
                                    <img class="object-contain max-h-48 w-full" src="{{ $product->image->url }}"
                                        alt="">

                                    <div class="absolute top-0 right-0">
                                        <div class="h-10 w-10">
                                            <img class="w-full object-contain" src="{{ $product->store->image->url }}"
                                                alt="{{ $product->store->title }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <p class="h-12">
                                        <a class="product_title"
                                            href="{{ route('product.show', $product) }}">{{ $product->title }}</a>
                                    </p>
                                    <div class="mt-2 flex items-center justify-between">
                                        <div>
                                            <span>
                                                <span class="font-semibold text-lg">
                                                    {{ $product->price }}
                                                </span>
                                                грн.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="product_content hidden border-b border-x p-4 bg-base-100 absolute z-20 rounded-b-lg shadow-lg">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit sed repudiandae, eius quisquam
                            maxime reiciendis est sit quibusdam quaerat nemo atque, in quod dolores, inventore tempora
                            maiores architecto accusantium magni.
                        </div> --}}
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="px-2 py-8">
                {{ $products->links() }}
            </div>
        </main>
    </div>

</div>
