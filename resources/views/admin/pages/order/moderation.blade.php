@extends('layouts.admin')

@section('content')
    @livewire('models.order.moderation', compact('order'))
@endsection
