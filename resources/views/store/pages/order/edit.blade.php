@extends('layouts.store')

@section('content')
    @livewire('models.order.edit',compact('order'))
@endsection
