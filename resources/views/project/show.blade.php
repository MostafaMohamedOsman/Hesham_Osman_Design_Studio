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
        <div class="col-12">
            <div class="col-6 show">
                <h2>Project Name : {{ $project->name }}</h2>
                <h2>Project Description : {{ $project->desc }}</h3>
            </div>
        </div>
    <!-- Image management form -->
    <form id="image-management-form" action="{{ route('project.update_images', $project->id) }}" method="POST">
        @csrf

        <div class="row" id="images-gallery">
            @forelse ($project->images as $image)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 image-item" data-id="{{ $image->id }}">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-2 d-flex flex-column">
                            <img src="{{ url("dist/img/images/$image->img") }}" alt="img"
                                class="w-full h-48 object-cover rounded mb-2" style="object-fit:cover;" />

                            <div class="mt-2 d-flex justify-content">
                                <button type="button" class="mr-2 btn btn-sm btn-light move-left" title="Move Left">
                                    <i class="fas fa-arrow-left"></i>
                                </button>
                                <button type="button" class="mr-2 btn btn-sm btn-light move-right" title="Move Right">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                                <button type="button" class="mr-2 btn btn-sm btn-light delete-image" title="Delete">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="image_order[]" value="{{ $image->id }}" />
                </div>
            @empty
                <h4>No Images</h4>
            @endforelse
        </div>

        <!-- Deleted images will be appended here as hidden inputs -->
        <div id="deleted-images-inputs"></div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save mr-1"></i> Save Image Changes
        </button>
    </form>

    <hr class="mt-4 mb-4">
        <hr class="mt-4 mb-4">

@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const gallery = document.getElementById('images-gallery');
            const deletedInputsContainer = document.getElementById('deleted-images-inputs');
            if (!gallery) return;

            gallery.addEventListener('click', function (e) {
                const btn = e.target.closest('button');
                if (!btn) return;
                const item = btn.closest('.image-item');
                if (!item) return;

                if (btn.classList.contains('move-left')) {
                    const prev = item.previousElementSibling;
                    if (prev && prev.classList && prev.classList.contains('image-item')) {
                        gallery.insertBefore(item, prev);
                    }
                }

                if (btn.classList.contains('move-right')) {
                    const next = item.nextElementSibling;
                    if (next && next.classList && next.classList.contains('image-item')) {
                        gallery.insertBefore(next, item);
                    }
                }

                if (btn.classList.contains('delete-image')) {
                    const id = item.getAttribute('data-id');
                    // remove item from DOM (this also removes its image_order input)
                    item.parentNode.removeChild(item);
                    // append a hidden input to record deletions
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'images_to_delete[]';
                    input.value = id;
                    deletedInputsContainer.appendChild(input);
                }
            });
        });
    </script>
@endsection
