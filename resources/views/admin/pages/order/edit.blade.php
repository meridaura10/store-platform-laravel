@extends('layouts.admin')

@section('content')
    @livewire('models.order.edit',compact('order'))
@endsection
