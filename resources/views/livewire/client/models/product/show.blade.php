<div class="py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row -mx-4">
            <div class="md:flex-1 px-4">
                <div class="h-[460px] w-[500px] relative rounded-lg mb-4" x-data="{ image: 0 }">
                    <div class="w-full flex overflow-hidden">
                        @foreach ($product->images as $key => $image)
                            <div class="w-full h-full" x-show="image == {{ $key }}">
                                <img class="w-full max-h-[460px] object-cover" src="{{ $image->url }}"
                                    alt="Product Image">
                            </div>
                        @endforeach
                    </div>
                    <div class="absolute z-30 right-0 left-0 bottom-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <button x-show="image > 0" @click="image = image - 1"
                                    class="btn btn-md btn-outline">back</button>
                            </div>

                            <div>
                                <button x-show="image < {{ count($product->images) - 1 }}" @click="image = image + 1"
                                    class="btn btn-md btn-outline">next</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="md:flex-1 px-4">
                <h2 class="text-2xl font-bold text-gray-800 :text-white mb-2">{{ $product->title }}</h2>
                <div class="flex mb-4">
                    <div class="mr-4">
                        <span class="font-bold text-gray-700 :text-gray-300">Price:</span>
                        <span class="text-gray-600 :text-gray-300">{{ $product->price }} грн.</span>
                    </div>
                    <div>
                        <span class="font-bold text-gray-700 :text-gray-300">Availability:</span>
                        <span class="text-gray-600 :text-gray-300">In Stock</span>
                    </div>
                </div>
                <div>
                    <span class="font-bold text-gray-700 :text-gray-300">Product Description:</span>
                    <p class="text-gray-600 :text-gray-300 text-sm mt-2">
                        {{ $product->description }}
                    </p>
                </div>
                <div class="flex mt-5">
                    @if (basket()->hasProduct($product))
                        <a href="{{ route('basket.index') }}">
                            <button
                                class="bg-green-600 btn flex items-center gap-2 hover:bg-green-500 transition-all  rounded-full text-white">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white" viewBox="0 0 24 24"
                                        width="28" height="28">
                                        <path
                                            d="M4.00488 16V4H2.00488V2H5.00488C5.55717 2 6.00488 2.44772 6.00488 3V15H18.4433L20.4433 7H8.00488V5H21.7241C22.2764 5 22.7241 5.44772 22.7241 6C22.7241 6.08176 22.7141 6.16322 22.6942 6.24254L20.1942 16.2425C20.083 16.6877 19.683 17 19.2241 17H5.00488C4.4526 17 4.00488 16.5523 4.00488 16ZM6.00488 23C4.90031 23 4.00488 22.1046 4.00488 21C4.00488 19.8954 4.90031 19 6.00488 19C7.10945 19 8.00488 19.8954 8.00488 21C8.00488 22.1046 7.10945 23 6.00488 23ZM18.0049 23C16.9003 23 16.0049 22.1046 16.0049 21C16.0049 19.8954 16.9003 19 18.0049 19C19.1095 19 20.0049 19.8954 20.0049 21C20.0049 22.1046 19.1095 23 18.0049 23Z">
                                        </path>
                                    </svg>
                                </div>
                                продукт вже у вас в кошику
                            </button>
                        </a>
                    @else
                        <div wire:click='addToBasket' class="w-1/2 px-2">
                            <button
                                class="w-full rounded-full bg-gray-900 text-white py-2 px-4 font-bold hover:bg-gray-800">Add
                                to Cart</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
