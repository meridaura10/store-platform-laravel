@extends('layouts.client')

@section('content')
    <div class="container mx-auto">
        @livewire('client.models.product.show', compact('product'))
    </div>
@endsection
