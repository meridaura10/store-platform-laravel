@extends('layouts.store')

@section('content')
    <div class="p-6">
        @livewire('store.models.role.form', compact('role'))
    </div>
@endsection
