@extends('layouts.dashboard')
@section('content')

<h2 class="my-4">Add role</h2>
@if($errors->any())
<div class="alert alert-danger">
Error
</div>
@endif

<form action="{{route('roles.store')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group mb-3">
        <label for="">Name:</label>
        <input type="text" name="name" value="{{ old('name')}}" class="form-control @error('name') is-invalid @enderror">
        @error('name')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Abilities:</label>
        <div>
        @foreach(config('abilities') as $key=>$label)
        <div class="mb-1">
        <label for="">
        <input type="checkbox" name="abilities[]" value="{{$key}}">{{$label}}
        </label>
        </div>
        @endforeach
        </div>
        
        @error('abilities')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>




    
    

    <div>
        <button type="submit" class="btn btn-primary">Add</button>
    </div>


</form>

@endsection
