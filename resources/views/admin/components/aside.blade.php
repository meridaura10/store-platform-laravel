<aside class="bg-gray-800 px-3 text-white w-48 flex-shrink-0 pt-2">
    <ul class="gap-4 grid">
        <li x-data="{ open: false }">
            <div x-on:click="open = ! open" class="flex justify-between items-center cursor-pointer">
                <h2>Магазин</h2>
                <i x-bind:class=" open ? 'ri-arrow-down-s-line' : 'ri-arrow-up-s-line'"></i>
            </div>

            <ul x-show="open" class="mt-1 flex flex-col gap-1">
                <a href="{{ route('admin.product.index') }}">
                    <li class="hover:bg-gray-700 transition-all rounded-lg py-1 px-2">
                        Продукти
                    </li>
                </a>
                <a href="{{ route('admin.order.index') }}">
                    <li class="hover:bg-gray-700 transition-all rounded-lg py-1 px-2">
                        Замовлення
                    </li>
                </a>
            </ul>
        </li>

        <li x-data="{ open: false }">
            <div x-on:click="open = ! open" class="flex justify-between items-center cursor-pointer">
                <h2>Модерація</h2>
                <i x-bind:class=" open ? 'ri-arrow-down-s-line' : 'ri-arrow-up-s-line'"></i>
            </div>

            <ul x-show="open" class="mt-1 flex flex-col gap-1">
                <a href="{{ route('admin.moderation.product.index') }}">
                    <li class="hover:bg-gray-700 transition-all rounded-lg py-1 px-2">
                        Продукти
                    </li>
                </a>

                <a href="{{ route('admin.moderation.stor.index') }}" >
                    <li class="hover:bg-gray-700 transition-all rounded-lg py-1 px-2">
                        Магазини
                    </li>
                </a>
            </ul>
        </li>
        
        <li x-data="{ open: false }">
            <div x-on:click="open = ! open" class="flex justify-between items-center cursor-pointer">
                <h2>налаштування</h2>
                <i x-bind:class=" open ? 'ri-arrow-down-s-line' : 'ri-arrow-up-s-line'"></i>
            </div>

            <ul x-show="open" class="mt-1 flex flex-col gap-1">
                <a href="">
                    <li class="hover:bg-gray-700 transition-all rounded-lg py-1 px-2">
                        Користувачі
                    </li>
                </a>
            </ul>
        </li>
    </ul>
</aside>
