@extends('layouts.dashboard')
@section('content')

<h2 class="my-4">Add Category</h2>
@if($errors->any())
<div class="alert alert-danger">
Error
</div>
@endif

<form action="{{route('admin.categories.store')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group mb-3">
        <label for="">Name:</label>
        <input type="text" name="name" value="{{ old('name')}}" class="form-control @error('name') is-invalid @enderror">
        @error('name')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Parent:</label>
        <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
            <option value="">No parent</option>
            @foreach ($parents as $parent)

            <option value="{{$parent->id}}" @if($parent->id == old('parent_id')) selected @endif> {{$parent->name}}</option>

            @endforeach

        </select>
        @error('parent_id')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>



    <div class="form-group mb-3">
        <label for="">Descrition:</label>
        <textarea name="description"  class="form-control @error('description') is-invalid @enderror">{{ old('description')}}</textarea>
        @error('description')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Image:</label>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror ">
        @error('image')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Status:</label>
        <div>
            <label> <input type="radio" name="status" value=" active" @if(old('status')=='active') checked @endif> Active</label>
            <label> <input type="radio" name="status" value="inactive"  @if(old('status')=='inactive') checked @endif> Inactive</label>
        </div>
        @error('status')
        <p class="alert-warning">{{$message}}</p>
                 @enderror
    </div>

    <div>
        <button type="submit" class="btn btn-primary">Add</button>
    </div>


</form>

@endsection
