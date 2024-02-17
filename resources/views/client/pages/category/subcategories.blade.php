@extends('layouts.client')

@section('content')
    <div class="container mx-auto h-full mt-8 flex items-center justify-center">
        <div class="grid grid-cols-3 gap-3 w-full">
            @foreach ($category->subcategories as $category)
                <div class="w-full  category-hover">
                    <div class="flex flex-col items-center justify-center text-center">
                        <div>
                            <img class="mx-auto w-full h-52 object-contain" src="{{ $category->image->url }}" alt="">
                        </div>

                        <a class="block mt-3" href="{{ route('category.show', $category) }}">
                            <p class="font-bold p-1 rounded-lg text-xl">
                                {{ $category->title }}
                            </p>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
