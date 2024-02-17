@extends('layouts.store')

@section('content')
    <div class="p-6">
        @component('ui.card')
            <div class="flex justify-between items-center">
                <div class="flex gap-4 items-center">
                    <img class="max-w-16 max-h-16" src="{{ $store->image->url }}" alt="logo images">
                    <h1 class="font-bold text-2xl">{{ $store->title }}</h1>
                </div>
                <div class="flex gap-8">
                    <div>
                        Контакти
                        <ul>
                            <li>
                                email: {{ $store->email }}
                            </li>
                            <li>
                                phone: {{ $store->phone }}
                            </li>
                        </ul>
                    </div>
                    <div>
                        Власник
                        <ul>
                            <li>
                                email: {{ auth()->user()->email }}
                            </li>
                            <li>
                                phone: {{ $store->phone }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                    <a href="{{ route('store.admin.store.edit', request()->route('store')) }}">
                        <button class="btn btn-primary">Редагувати</button>
                    </a>
                </div>
            </div>
        @endcomponent

        <div class="mt-4">
            @component('ui.card')
                <p>
                    {{ $store->description }}
                </p>
            @endcomponent
        </div>
    </div>
@endsection
