@extends('layouts.client')

@section('content')
    <div class="text-center mt-5">
        <a href="{{ route('user.cabinet.store.create') }}">
            <button class="btn btn-primary">
                Створити свій магазин
            </button>
        </a>
    </div>

    @livewire('client.models.storeUser.index')
@endsection
