@extends('layouts.admin')
@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('List of Podcast') }}</h1>
    <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm mb-2"><i class="fa fa-angle-left"></i> Back</a>
    <div class="d-flex mt-4 flex-wrap">
        @foreach ($podcasts as $book)
        <div  class="m-4 text-center " style="position:relative;" x-data="{showInfo:false}" x-on:mouseover="showInfo = true" x-on:mouseout="showInfo = false">
            <div  id="{{ $book->id }}" style="cursor:pointer;@if(request()->id == $book->id)  box-shadow:0px 0px 10px 10px #1A0A49; @else box-shadow:10px 5px 2px #555 ; @endif height: 200px; width: 150px; background:url('{{ $book->cover }}');background-size:contain;background-position:center;">

            </div>
            <div class="mt-2">
                <a href="{{ route('podcast.show', $book) }}">{{ $book->title }}</a>
            </div>
            <div  x-show.transition="showInfo" style="position:absolute;top:-10px;left:100px; height:250px; width:200px;background:rgba(17,0,31, 0.9);z-index:999" >
                <div style="position:absolute;top:6px;left:-14px;height:32px; width:32px;border:4px #014E7F solid;background:url('{{ asset('img/card-bg-custom.png') }}');background-position:center;border-top:none;border-right:none;transform:rotate(45deg);z-index:998;"></div>
                <p class="text-white p-2" style="@if(strlen($book->title) >= 10) font-size:11px; @endif height:45px;box-shadow:0px 5px #000;border:4px #014E7F solid;border-left:none; background:url('{{ asset('img/card-bg-custom.png') }}');background-position:center;z-index:999;">
                    {{ $book->title }}
                </p>
                <div class="px-2 text-left text-white">
                    <div class="mt-1" style="text-transform: capitalize">
                        Cost: {{ $book->cost == 0 ? 'FREE':$book->cost }} {{ $book->cost_type }}
                    </div>
                    <div class="mt-1" style="border-top:1px solid white;"></div>
                    <div class="mt-1">
                        Date Uploaded: {{ $book->created_at->format('m/d/y') }}
                    </div>
                    <div class="mt-1" style="border-top:1px solid white;"></div>
                    <div class="mt-1">
                        Ratings: ---
                    </div>
                    <div class="mt-1">
                        Comments: ---
                    </div>
                    <div class="mt-1">
                        Likes: ---
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection

@section('top')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
@endsection