@extends('layouts.app')

@section('content')
    <div class="flex flex-col p-8">
        @livewire('polling-test')
    </div>

    <div class="h-3/12"></div>

    <div class="my-8">
        <h2 class="text-lg font-semibold mt-4">Events Example with Tags</h2>
        @livewire('tags-component')
    </div>

    <div class="h-3/12"></div>

    <div class="flex flex-col p-8">
        @livewire('data-tables')
    </div>
@endsection
