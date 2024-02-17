<div class="bg-gray-100 overflow-hidden shadow-xl rounded-lg border-gray-200 p-6">
    <ul class="grid grid-cols-10 gap-6">
        @foreach ($categories as $category)
            <li>
                <a href="{{ route('category.show', $category) }}" class="block category-hover">
                    <div class="text-center">
                        <div class="mx-auto w-20 h-20">
                            <img class="w-full h-full rounded-full" src="{{ $category->image->url }}" alt="">
                        </div>
                        <div class="mt-1">
                            <p class="font-semibold p-1 rounded-lg">
                                {{ $category->title }}
                            </p>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
