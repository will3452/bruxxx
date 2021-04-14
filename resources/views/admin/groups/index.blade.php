@extends('layouts.master')
@section('main-content')
    <div x-data="{createType:@if(isset(request()->createType)) true @else false @endif }">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-4 text-gray-800">{{ __('Groups') }}</h1>
            <button class="btn btn-primary btn-sm"  x-on:click="createType = !createType">
                    <i class="fa" :class="{'fa-angle-right':!createType, 'fa-angle-down':createType}"></i> 
                    Add Group Type
                </button>
        </div>
        <div class="card my-2" x-show.transition="createType">
            <div class="card-header">
                Add Group Type
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                    <form action="{{ route('admin.grouptypes.store') }}" method="post">
                        @csrf
                            <div class="input-group">
                                <input type="text" placeholder="Enter Group Type Here." name="name" class="form-control">
                                <button class="btn btn-primary input-group-append">Add</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 d-flex align-items-start" style="flex-wrap: wrap">
                        @foreach (\App\GroupType::get() as $item)
                            <div class="d-flex align-items-center text-white bg-primary p-1 px-2 rounded m-1">
                                <div class="mr-2">
                                    {{ $item->name }}
                                </div>
                                <form action="{{ route('admin.grouptypes.destroy', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger rounded-circle btn-sm">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="d-flex justify-content-between mb-2">
        <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm"><i class="fa fa-angle-left"></i> Back</a>
    </div> --}}
    <div>
        <a href="{{ url()->current() }}?status=pending" class="btn btn-sm p-1">@if((isset(request()->status) && request()->status == 'pending') || !isset(request()->status)) * @endif Pending</a>
        <a href="{{ url()->current() }}?status=approved" class="btn btn-sm p-1">@if(isset(request()->status) && request()->status == 'approved') * @endif Approved</a>
        <a href="{{ url()->current() }}?status=dis" class="btn btn-sm p-1">@if(isset(request()->status) && request()->status == 'dis') * @endif Dis Approved</a>
    </div>
    <table id="bookstable" class="table table-stripped table-bordered">
        <thead>
            <th>
                Name
            </th>
            <th>
                Creator
            </th>
            <th>
                Type
            </th>
            <th>
                No. Works
            </th>
            <th>
                No. Members
            </th>
            <th>
                Actions
            </th>
            <th>
                Reason
            </th>
        </thead>
        <tbody>
           
        </tbody>
    </table>
@endsection

@section('top')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
@endsection

@section('bottom')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.colVis.min.js"></script>
    <script>
        $(function(){
            $('#bookstable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            // 'copy', 'csv', 'excel', 'pdf','colvis'
            'pdf','colvis'
        ],
    });
        $('button').addClass('.btn')
        })
        
    </script>
@endsection