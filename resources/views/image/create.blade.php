@extends('super.super')

@section('title','Create Image')

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
    <form method="post" action="{{route('img.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
             <label for="subcatigories"> Project </label>
                <select class="form-control" id="subcatigories" name="project_id" >
                    <option >Select project</option>
                    @foreach($projects as $project)
                        <option {{old('project_id')==$project->id?"selected":""}}value="{{$project->id}}">{{$project->name}}</option>
                    @endforeach
                </select>
        </div>
         <div class="form-row">
            <label for="img"> Image </label>
            <input type="file" id="img" class="form-control" name="imgs[]" multiple >
        </div>
        <div class="form-row">
            <div class="col-6">
                <button type="submit" value="all" class="btn btn-primary my-4" name="button">Add Image</button>
            </div>
            <div class="col-6">
                <button type="submit" value="back" class="btn btn-success my-4" name="button">Add and Return</button>
            </div>
        </div>
    </form>
@endsection