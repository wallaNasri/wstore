@extends('layouts.dashboard')
@section('content')

<h2 class="my-4">Edite role</h2>

<form action="{{route('roles.update',$role->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="form-group mb-3">
        <label for="">Name:</label>
        <input type="text" name="name" value="{{$role->name}}" class="form-control @error('name') is-invalid @enderror ">
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
        <input type="checkbox" name="abilities[]" value="{{$key}}" @if(in_array( $key,$role->abilities)) checked @endif>{{$label}}
        </label>
        </div>
        @endforeach
        </div>
        
        @error('abilities')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>


    <div>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>


</form>
@endsection
