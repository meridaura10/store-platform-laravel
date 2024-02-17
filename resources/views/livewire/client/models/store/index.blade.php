<div class=" grid grid-cols-2 gap-6">
    @foreach ($stores as $store)
        <div class="bg-gray-100 overflow-hidden shadow-xl rounded-lg border-gray-200">
            <div class="px-4 py-5 sm:px-6">
                <img src="{{ $store->image->url }}" class="h-32 max-w-[400px] object-cover  mx-auto" alt="">
                <div class="mt-6 flex items-end gap-2 justify-center">
                    <h3 class=" hover:underline text-center text-3xl font-bold text-gray-900">
                        <a href="{{ route('store.show', $store) }}">
                            {{ $store->title }}
                        </a>
                    </h3>
                    <h3 class=" hover:underline text-center text-xl font-bold text-blue-500">
                        <a href="{{ route('store.product.index', $store) }}">
                            продукти
                        </a>
                    </h3>
                </div>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <dl class="space-y-8">
                    @foreach ($store->products as $product)
                        <div class="flex items-center gap-4 product">
                            <img class="h-16 w-16 object-cover rounded-lg" src="{{ $product->image->url }}"
                                alt="">
                            <div>
                                <div class="text-lg product_title leading-6 font-medium text-gray-900">
                                    <a href="{{ route('product.show', $product->id) }}">
                                        {{ $product->title }}
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
    @endforeach
</div>
