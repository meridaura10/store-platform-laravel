<header class="bg-[#192130] h-[48px] text-white shadow-md  py-3 px-3">
    <div class="flex justify-between h-full items-center">
        <h3>
            <a href="{{ route('store.admin.home', request()->route('store')) }}">
                Адмін панель магазину
            </a>
        </h3>
        <nav class="">
            <ul class="flex gap-2 items-center">
                @component('store.components.header-link', ['route' => 'store.admin.product.index'])
                    Продукти
                @endcomponent

                @component('store.components.header-link', ['route' => 'store.admin.store.show'])
                    Магазин
                @endcomponent

                @component('store.components.header-link', ['route' => 'store.admin.order.index'])
                    Замовлення
                @endcomponent

                @component('store.components.header-link', ['route' => 'store.admin.analitic.index'])
                    Аналітика
                @endcomponent

                @component('store.components.header-link', ['route' => 'store.admin.staff.index'])
                    Персонал
                @endcomponent

            </ul>
        </nav>
        <h3>
            {{ auth()->user()->name }}
        </h3>
    </div>
</header>
