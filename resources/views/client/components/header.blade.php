<div class="shadow-xl">
    <div class=" bg-base-100">
        <div class="max-w-[1024px] m-auto navbar">
            <div class="flex-1">
                <a href="{{ route('client.index') }}" class="btn btn-ghost text-xl">SPL</a>
            </div>
            <div class="flex-none gap-2 ">
                @livewire('client.components.header.basket-icon')
                @if (auth()->check())
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img alt="Tailwind CSS Navbar component"
                                src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                        </div>
                    </div>
                    <ul tabindex="0"
                        class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                        <li class="mb-1 pb-1 border-b">
                            <div class="p-2">
                                {{ auth()->user()->name }}
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('user.cabinet.index') }}" class="justify-between">
                                ваш профіль
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.cabinet.order.index') }}" class="justify-between">
                                ваші замовлення
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.cabinet.store.index') }}" class="justify-between">
                                Ваші магазини
                            </a>
                        </li>

                        <li>
                           <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">Вийти</button>
                           </form>
                        </li>
                    </ul>
                </div>
                @else
                <button class="btn">
                    <a href="{{ route('login') }}">
                        ввійти
                    </a>
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
