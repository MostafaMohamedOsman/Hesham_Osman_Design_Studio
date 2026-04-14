@extends('super.super')
@section('css')
<link href="{{url('dist\alt\customeEdits.css')}}">
@endsection

@section('title','Create Category')

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
    <form method="post" action="{{route('category.store')}}" enctype="multipart/form-data">
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
            <label for="img"> Image </label>
            <input type="file" id="img" class="form-control" name="img" >
        </div>
        <div class="form-row">
            <div class="col-6">
                <button type="submit" value="all" class="btn btn-primary my-4" name="button">Add Category</button>
            </div>
            <div class="col-6">
                <button type="submit" value="back" class="btn btn-success my-4" name="button">Add and Return</button>
            </div>
        </div>
    </form>
@endsection
