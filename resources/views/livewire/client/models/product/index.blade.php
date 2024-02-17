<div class="">
    <h2 class="text-3xl text-center font-bold mb-8">
        Продукти
    </h2>
    <div>
        <ul class="grid grid-cols-4 items-center justify-center border-l">
            @foreach ($products as $product)
                <li class="relative group transition-all">
                    <div class="border-b border-r product">
                        <div>
                            <div class="w-full h-48">
                                <img class="object-contain max-h-48 w-full" src="{{ $product->image->url }}" alt="">
                            </div>
                            <div class="p-4">
                                <p class="h-12">
                                    <a class="product_title" href="{{ route('product.show', $product) }}">{{ $product->title }}</a>
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
                                    {{-- <div>
                                        <button class="btn btn-primary">купити</button>
                                    </div> --}}
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
        
    </div>
</div>
