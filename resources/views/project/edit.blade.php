@extends('super.super')

@section('title','Update Project')

@section('content')
    <div class="col-12">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    @include('includes.includes')
    <form method="POST" action="{{ route('project.update', ['project' => $project->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="form-row">
            <div class="col-6">
                <label for="name"> Name </label>
                <input type="text" id="name" class="form-control" name="name"  value="{{$project->name}}">
            </div>
            <div class="col-6">
                <label for="desc"> Description </label>
                <input type="text" id="desc" class="form-control" name="desc" value="{{$project->desc}}">
            </div>
        </div>
        <div class="form-row">
            <label for="category_id"> Category </label>
            <select class="form-control" id="category_id" name="category_id">
                <option value="">Select category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (old('category_id', $project->category_id) == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <div class="col-12">
                <label for="imgs"> Project Images </label>
                <input type="file" id="imgs" class="form-control" name="imgs[]" multiple accept="image/*">
                <div id="img-gallery" class="d-flex flex-wrap gap-2 mt-2">
                    @foreach($project->images as $image)
                        <div class="border rounded p-0 img-item" data-type="existing" data-id="{{ $image->id }}" data-filename="{{ $image->img }}">
                            <div style="width:90px;height:90px;overflow:hidden;">
                                <img src="{{ url('dist/img/images/'.$image->img) }}" style="width:100%;height:100%;object-fit:cover;" />
                            </div>
                            <div class="d-flex gap-1 mt-1">
                                <button type="button" class="btn btn-sm btn-secondary btn-move-left"><i class="fas fa-arrow-left"></i></button>
                                <button type="button" class="btn btn-sm btn-secondary btn-move-right"><i class="fas fa-arrow-right"></i></button>
                                <button type="button" class="btn btn-sm btn-danger btn-mark-delete" data-id="{{ $image->id }}"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="image-order-inputs"></div>
                <div id="deleted-image-inputs"></div>
                <small class="form-text text-muted">Allowed types: jpg, jpeg, png, gif. Max 2MB per image.</small>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <button type="submit" value="all" class="btn btn-primary my-1" name="button">Update</button>
            </div>
        </div>
    </form>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sel = document.querySelector('select[name="category_id"]');
        if (!sel) return;
        function applySelected() {
            const pick = sel.querySelector('option[selected]');
            if (pick) sel.value = pick.value;
            if (window.jQuery && jQuery.fn && jQuery.fn.select2) {
                jQuery(sel).trigger('change');
            } else {
                sel.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
        applySelected();
        setTimeout(applySelected, 150);
    });
</script>
@endsection
