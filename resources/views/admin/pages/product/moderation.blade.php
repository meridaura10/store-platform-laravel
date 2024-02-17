@extends('layouts.admin')

@section('content')
    @livewire('admin.models.product.moderation', compact('product'))
@endsection
