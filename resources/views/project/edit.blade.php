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
    <<form method="POST" action="{{ route('project.update', ['project' => $project->id]) }}" enctype="multipart/form-data">
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
            <label for="catigories"> Category </label>
                <select class="form-control" id="catigories" name="category_id">
                    <option >Select category</option>
                    @foreach ($categories as $category)
                        <option {{ $project->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">
                            {{ $category->name }}</option>
                    @endforeach
                </select>
        </div>
        <div class="form-row">
            <div class="col-6">
                <button type="submit" value="all" class="btn btn-primary my-1" name="button">Update</button>
            </div>
        </div>
    </form>
@endsection
