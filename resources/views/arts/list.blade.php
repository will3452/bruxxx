@extends('layouts.admin')
@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('List of Arts') }}</h1>
    <x-gohome/>
    <div class="d-flex mt-4 flex-wrap">
        @foreach ($arts as $book)
            <x-book-window :book="$book" link="{{ route('arts.show', $book) }}"/>
        @endforeach
    </div>
    
@endsection

@section('top')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
@endsection