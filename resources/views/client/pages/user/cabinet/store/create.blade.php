@extends('layouts.client')

@section('content')
    @livewire('client.models.store.create', compact('store'))
@endsection
