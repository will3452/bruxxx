@extends('layouts.admin')
@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('List of Books') }}</h1>
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm mb-2"><i class="fa fa-angle-left"></i> Back</a>
    </div>
    <div class="row">
        @foreach($books as $book)
            <div class="col-md-2 col-6 text-center all {{ $book->class }} {{ empty($book->published_date)  ? 'published':'not-yet'}}">
               
                    <div class="parent">
                        <img src="{{ $book->cover }}" alt="" class="child">
                        <div class="parent-title">
                            <strong class="text-lg text-light px-2 text-uppercase">
                                <a href="{{ route('books.show', $book) }}" class="link-{{ $book->id }}"> {{ $book->title }} </a>
                            </strong>
                        </div>
                    </div>
                    <a href="{{ route('books.show', $book) }}">{{ $book->title }}</a>
            </div>
        @endforeach
        <div class="col-md-2 col-6 text-center" >
            <div id="create-link" class="d-flex align-items-center justify-content-center">
                <a href="{{ route('books.create') }}">
                    <i class="fa fa-plus fa-lg text-secondary"></i> 
                </a>
            </div>
        </div>
            
        
    </div>
@endsection

@section('top')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
    <style>
        .parent{
            width:100%;
            height:250px;
        }
        .child {
            height:100%;
            width:100%;
            object-fit: cover;
            border-radius: 10px;
            transform: scale(0.95);
            transition: all 500ms;
        }
        .parent-title {
            opacity: 0;
            position: relative;
            top:-150px;
            
            text-decoration: none;
            background: black;
            width:auto;
            transform: scale(0.95);
            transition: all 250ms;
        }
        .parent:hover .child{
            transform: scale(1);
            filter:grayscale(10);
        }
        .parent:hover .parent-title{
            opacity:0.7;
            transform: scale(1);
        }
        .parent-title a {
            text-decoration: none !important;
            color: #fff !important;
        }
        #create-link {
         height:250px !important;
         font-size:200%;
         width: 100%;
         height: 100%;
         border:2px solid #eee;
         border-radius: 10px;
         transform: scale(0.95);
         transition: all 500ms;
         background: #eee;
        }
        #create-link:hover{
            transform: scale(1);
        }
    </style>
@endsection
@section('bottom')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(function(){
            $('#bookstable').DataTable();
        })
    </script>
@endsection