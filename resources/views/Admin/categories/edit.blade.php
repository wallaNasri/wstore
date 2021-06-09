@extends('layouts.dashboard')
@section('content')

<h2 class="my-4">Edite Category</h2>

<form action="{{route('admin.categories.update', $id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="form-group mb-3">
        <label for="">Name:</label>
        <input type="text" name="name" value="{{$category->name}}" class="form-control @error('name') is-invalid @enderror ">
        @error('name')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Parent:</label>
        <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
            <option value="">No Parent</option>
            @foreach ($parents as $parent)
            <option value="{{$parent->id}}" @if($parent->id==$category->parent_id) selected @endif >{{$parent->name}}</option>

            @endforeach

        </select>
        @error('parent_id')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>



    <div class="form-group mb-3">
        <label for="">Descrition:</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror"><?= $category->description ?></textarea>
        @error('description')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Image:</label>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
        @error('image')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Status:</label>
        <div>
            <label> <input type="radio" name="status" value="active" @if($category->status=='active') checked @endif> Active</label>
            <label> <input type="radio" name="status" value="inactive" @if($category->status=='inactive') checked @endif> Inactive</label>
        </div>
        @error('status')
        <p class="alert-warning">{{$message}}</p>
                 @enderror
    </div>

    <div>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>


</form>
@endsection
