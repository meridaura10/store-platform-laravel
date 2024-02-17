@extends('layouts.store')

@section('content')
    @livewire('models.order.moderation', compact('order'))
@endsection
