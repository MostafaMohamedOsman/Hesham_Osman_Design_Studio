@extends('super.super')

@section('title','Update Category')

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
    <form method="POST" action="{{ route('category.update', ['category' => $category->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="form-row">
            <div class="col-6">
                <label for="name"> Name </label>
                <input type="text" id="name" class="form-control" name="name"  value="{{$category->name}}">
            </div>
            <div class="col-6">
                <label for="desc"> Description </label>
                <input type="text" id="desc" class="form-control" name="desc" value="{{$category->desc}}">
            </div>
        </div>
        <div class="form-row">
            <label for="img"> Image </label>
            <input type="file" id="img" class="form-control" name="img" >
        </div>
        <div class="col-4">
                <img src="{{url("dist/img/categories/$category->img")}}" alt="{{$category->name}}" class="w-100 my-1">
            </div>
        <div class="form-row">
            <div class="col-6">
                <button type="submit" value="all" class="btn btn-primary my-1" name="button">Update</button>
            </div>
        </div>
    </form>
@endsection
