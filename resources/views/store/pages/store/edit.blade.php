@extends('layouts.store')

@section('content')
    <div class="p-6">
        @livewire('store.models.store.form',compact('store'))
    </div>
@endsection
