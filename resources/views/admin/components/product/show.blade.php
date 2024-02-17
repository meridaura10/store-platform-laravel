<div>
    <div class="mb-3">
        @component('ui.card')
            <span class="font-bold text-xl">title:</span> <span class="font-semibold text-lg">{{ $product->title }}</span>
        @endcomponent
    </div>

    <div class="mb-3">
        @component('ui.card')
            <span class="font-bold text-xl">description:</span> <span
                class="font-semibold text-lg">{{ $product->description }}</span>
        @endcomponent
    </div>

    <div class="mb-3">
        @component('ui.card')
            <span class="font-bold text-xl">categories</span>
            <ul>
                @foreach ($product->categories as $category)
                    <li>
                        {{ $category->title }}
                    </li>
                @endforeach
            </ul>
        @endcomponent
    </div>

    <div class="mb-3">
        @component('ui.card')
            <div>
                <span class="font-bold text-xl">price:</span> <span
                    class="font-semibold text-lg">{{ $product->price }}</span>
            </div>
            <div>
                <span class="font-bold text-xl">quantity:</span> <span
                    class="font-semibold text-lg">{{ $product->quantity }}</span>
            </div>
        @endcomponent
    </div>

    <div class="mb-3">
        @component('ui.card')
            <div class="grid grid-cols-4 items-center justify-center">
                @foreach ($product->images as $image)
                    <div>
                        <img class="h-16 object-contain" src="{{ $image->url }}" alt="">
                    </div>
                @endforeach
            </div>
        @endcomponent
    </div>
</div>
