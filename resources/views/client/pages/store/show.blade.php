@extends('layouts.client')

@section('content')
    <div class="container mx-auto pt-6">
        <div>
            @component('ui.card')
                <div class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold">
                        {{ $store->title }}
                    </h1>
                    <h1 class="text-xl font-semibold hover:underline cursor-pointer text-blue-500">
                        <a href="{{ route('store.product.index', $store) }}">переглянути продукти</a>
                    </h1>
                </div>
            @endcomponent
        </div>
        <div class="mt-4">
            @component('ui.card')
                <h1 class="text-xl font-bold">
                    {{ $store->description }}
                </h1>
            @endcomponent
        </div>
    </div>
@endsection
