<div class="container mx-auto px-4">
    <div>
        <div class="bg-base-100 p-4 mb-8 shadow-xl sm:p-6 lg:p-8 rounded-lg">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold">Мій магазин - {{ $shop->title }}</h1>
                    <p class="text-sm ">Власник: {{ $shop->user->name }}</p>
                    <p class="text-sm ">Телефон: +380 123 456 789</p>
                    <p class="text-sm ">Email: {{ $shop->user->email }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <div>
                        <a href="{{ route('user.cabinet.shop.product.index') }}">
                            <button class="btn btn-primary">
                                Товари
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Тут ви можете додати опис свого магазину -->
            <div class="mt-4">
                <p class="text-lg ">Мій магазин - це платформа, де ви можете знайти різноманітні товари для
                    дому, саду, кухні та інших сфер життя. У нас ви можете знайти якісні, екологічні та доступні продукти
                    від перевірених виробників. Ми пропонуємо швидку доставку, гарантію якості та відмінний сервіс.</p>
            </div>
            <!-- Тут ви можете додати основні категорії свого магазину -->
            <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                <a href="#" class="flex flex-col items-center p-4 bg-gray-100 hover:bg-gray-200 rounded-lg">
                    <svg class="h-10 w-10 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="mt-2 text-gray-900 text-sm font-medium">Для дому</span>
                </a>
                <a href="#" class="flex flex-col items-center p-4 bg-gray-100 hover:bg-gray-200 rounded-lg">
                    <svg class="h-10 w-10 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="mt-2 text-gray-900 text-sm font-medium">Для саду</span>
                </a>
                <a href="#" class="flex flex-col items-center p-4 bg-gray-100 hover:bg-gray-200 rounded-lg">
                    <svg class="h-10 w-10 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h4m4-16h4a2 2 0 012 2v10a2 2 0 01-2 2h-4m-4 0H6a2 2 0 01-2-2V8a2 2 0 012-2h4m4 0h4a2 2 0 012 2v10a2 2 0 01-2 2h-4M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="mt-2 text-gray-900 text-sm font-medium">Для кухні</span>
                </a>
                <a href="#" class="flex flex-col items-center p-4 bg-gray-100 hover:bg-gray-200 rounded-lg">
                    <svg class="h-10 w-10 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <span class="mt-2 text-gray-900 text-sm font-medium">Інші категорії</span>
                </a>
            </div>
        </div>
    
        <div class="bg-base-100 p-4 shadow-xl rounded-lg mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Your Analytics</h3>
                <a href="#" class="text-sm text-blue-600 hover:underline">See More</a>
            </div>
            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                <div class="bg-blue-100  p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-800 font-medium">Sales</span>
                    </div>
                    <div class="text-gray-700">
                        <p class="text-2xl font-bold">12</p>
                        <p class="text-sm">This month</p>
                    </div>
                </div>
                <div class="bg-green-100 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                        <span class="text-gray-800 font-medium">Revenue</span>
                    </div>
                    <div class="text-gray-700">
                        <p class="text-2xl font-bold">$1,200</p>
                        <p class="text-sm">This month</p>
                    </div>
                </div>
                <div class="bg-yellow-100 p-4 rounded-lg  ">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="text-gray-800 font-medium">Visitors</span>
                    </div>
                    <div class="text-gray-700">
                        <p class="text-2xl font-bold">240</p>
                        <p class="text-sm">This month</p>
                    </div>
                </div>
                <div class="bg-red-100 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                        </svg>
                        <span class="text-gray-800 font-medium">Conversion</span>
                    </div>
                    <div class="text-gray-700">
                        <p class="text-2xl font-bold">5%</p>
                        <p class="text-sm">This month</p>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
