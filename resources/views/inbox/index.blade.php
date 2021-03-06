@extends('layouts.admin')
@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Messages') }}</h1>
    <a href="{{ route('home') }}" class="btn btn-primary btn-sm mb-2"><i class="fa fa-angle-left"></i> Back</a>
    @include('partials.alert')
    @if (count($messages))
    <ul class="list-group">
        @foreach ($messages as $message)
            <x-inbox-card :message="$message"/>
        @endforeach
    </ul>
    <div class="flex mt-5">
        {{ $messages->links() }}
    </div>
    @else
        <x-empty></x-empty>
    @endif
@endsection