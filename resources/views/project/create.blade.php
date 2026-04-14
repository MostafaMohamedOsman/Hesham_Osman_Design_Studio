@extends('super.super')

@section('title','Create Project')

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
    <form method="post" action="{{route('project.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="col-6">
                <label for="name"> Name </label>
                <input type="text" id="name" class="form-control" name="name"  value="{{old('name')}}">
            </div>
            <div class="col-6">
                <label for="desc"> Description </label>
                <input type="text" id="desc" class="form-control" name="desc" value="{{old('desc')}}">
            </div>
        </div>
        <div class="form-row">
            <label for="category_id"> Category </label>
            <select class="form-control" id="category_id" name="category_id">
                <option value="">Select category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <div class="col-12">
                <label for="imgs"> Project Images </label> 
                <input type="file" id="imgs" class="form-control" name="imgs[]" multiple accept="image/*">
                <div id="img-previews" class="d-flex flex-wrap gap-2 mt-2"></div>
                <div id="image-order-inputs"></div>
                <small class="form-text text-muted">Allowed types: jpg, jpeg, png, gif. Max 2MB per image.</small>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <button type="submit" value="all" class="btn btn-primary my-4" name="button">Add Project</button>
            </div>
            <div class="col-6">
                <button type="submit" value="back" class="btn btn-success my-4" name="button">Add and Return</button>
            </div>
        </div>
        <script>
            // keep submit buttons disabled after submit to avoid double posts
            document.addEventListener('DOMContentLoaded', function(){
                const form = document.querySelector('form');
                if (form){
                    form.addEventListener('submit', function(){
                        const buttons = form.querySelectorAll('button[type="submit"]');
                        buttons.forEach(b => b.disabled = true);
                    });
                }
            });
        </script>
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
        // Some UI plugins may initialize after DOMContentLoaded — try again shortly
        setTimeout(applySelected, 150);
    });
</script>
@endsection