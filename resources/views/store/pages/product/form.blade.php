@extends('layouts.store')

@section('content')
    <div class="p-6">
        @livewire('store.models.product.form', compact('product'))
    </div>
@endsection
