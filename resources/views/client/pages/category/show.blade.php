@extends('layouts.client')

@section('content')
    <div class="container mx-auto">
        @livewire('client.models.category.show',compact('category'))
    </div>
@endsection
