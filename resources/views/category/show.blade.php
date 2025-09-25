@extends('super.super')

@section('title', 'Show category')

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    @include('includes.includes')
    <div class="col-12">
        <div class="col-6">
            <h2>Category Name : {{ $category->name }}</h2>
            <h3>Category Description : {{ $category->desc }}</h3>
        </div>
        <div class="col-4">
            <img src="{{ url("dist/img/categories/$category->img") }}" alt="{{ $category->name }}" class="w-100" />
        </div>
    </div>
    <div class="row">
        @forelse ($category->projects as $project)
            <div class="col-lg-3 col-6">
                <div class="small-box">
                    <div class="inner">
                        <h4>{{ $project->name }}</h4>
                        <p>{{ $project->desc }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <a class="btn btn-warning" href="{{ route('project.edit', $project->id) }} " style="margin:8px">Edit</a>
                    <form class="d-inline" method="post" action="{{ route('project.destroy', $project->id) }} " style="margin:8px">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                    <a class="btn btn-primary" href="{{ route('project.show', $project->id) }}" style="margin:8px ">Show Images</a>
                </div>
            </div>
        @empty
            <h4>No Projects</h4>
        @endforelse 
    </div>
    <hr class="mt-4 mb-4">
@endsection

@section('js')
    <!-- DataTables  & Plugins -->
    <script src="{{ url('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ url('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ url('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
