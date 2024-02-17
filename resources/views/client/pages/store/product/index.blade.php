@extends('layouts.client')

@section('content')
    <div class="container mx-auto">
        @livewire('client.models.store.product.index', compact('store'))
    </div>
@endsection
