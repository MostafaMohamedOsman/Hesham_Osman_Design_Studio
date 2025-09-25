@extends('super.super')

@section('title' ,"Show project")

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    @include('includes.includes')
    <h2>Project Name : {{ $project->name }}</h2>
    <h3>Project Description : {{ $project->desc }}</h3>
        <div class="row">
            @forelse ($project->images as $image)
              <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="small-box">
                        <div class="inner">
                            <img src="{{ url("dist/img/images/$image->img") }}" alt="img"
                                style="width:100%; height:200px; object-fit:cover;" />
                        </div>
                        <div class="icon">
                            {{-- <i class="fas fa-box"></i> --}}
                        </div>
                        <form class="d-inline" method="post" action="{{ route('img.destroy', $image->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-block mt-2">Delete</button>
                        </form>
                    </div>
                </div>  
            @empty
                <h4>No Images</h4>
            @endforelse 
                
        </div>
        <hr class="mt-4 mb-4">

@endsection

{{-- @section('js')
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
@endsection --}}
