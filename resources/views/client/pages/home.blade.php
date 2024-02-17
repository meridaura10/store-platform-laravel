@extends('layouts.client')

@section('content')
    <div class="container mx-auto">
        <div class="mt-8">
            <h1 class="font-bold text-3xl text-center">
                Розділи на сервісі SPL
            </h1>
        </div>

        <div class="mt-8">
            @livewire('client.models.category.index')
        </div>

        <div class="mt-8">
            <h1 class="font-bold text-3xl text-center">
                Найпопулярніші магазини
            </h1>
        </div>

        <div class="mt-8 pb-6">
            @livewire('client.models.store.index')
        </div>
    </div>
@endsection
