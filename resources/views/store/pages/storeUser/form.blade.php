@extends('layouts.store')

@section('content')
    <div class="p-6">
        @livewire('store.models.storeUser.form', compact('storeUser'))
    </div>
@endsection
