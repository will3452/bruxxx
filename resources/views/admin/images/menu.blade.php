@extends('layouts.master')

@section('main-content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-4 text-gray-800"><i class="fa fa-image"></i> Image management</h1>
    </div>
    <div>
        <a href="{{ route('admin.images.announcement') }}">Marquee</a> | 
        <a href="{{ route('admin.images.banner') }}">Banners in sliders</a> | 
        <a href="{{ route('admin.images.preloader') }}">Preloaders</a> | 
        <a href="{{ route('admin.images.newspaper') }}">Newspapers</a> | 
        <a href="{{ route('admin.images.bulletin') }}">Bulletin</a>
    </div>
@endsection
