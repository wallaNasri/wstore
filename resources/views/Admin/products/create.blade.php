@extends('layouts.dashboard')
@section('title','Add product')
@section('content')

@if($errors->any())
<div class="alert alert-danger">
Error
</div>
@endif

<form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group mb-3">
        <label for="">Name:</label>
        <input type="text" name="name" value="{{ old('name')}}" class="form-control @error('name') is-invalid @enderror">
        @error('name')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Category:</label>
        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
            <option value="">Select Category</option>
            @foreach ($categories as $category)

            <option value="{{$category->id}}" @if($category->id == old('category_id')) selected @endif> {{$category->name}}</option>

            @endforeach

        </select>
        @error('category_id')
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
        <label for="">Gallery:</label>
        <input type="file" name="gallery[]" multiple class="form-control @error('gallery') is-invalid @enderror ">
        @error('gallery')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Price:</label>
        <input type="number" name="price" value="{{ old('price')}}" class="form-control @error('price') is-invalid @enderror">
        @error('price')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Sale Price:</label>
        <input type="number" name="sale_price" value="{{ old('sale_price')}}" class="form-control @error('sale_price') is-invalid @enderror">
        @error('sale_price')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Quantity:</label>
        <input type="number" name="quantity" value="{{ old('quantity')}}" class="form-control @error('quantity') is-invalid @enderror">
        @error('quantity')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Tags:</label>
        <input type="text" name="tags" value="{{ old('tags')}}" class=" tagify form-control @error('tags') is-invalid @enderror">
        @error('tags')
        <p class="invalid-feedback">{{$message}}</p>
         @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Status:</label>
        <div>
            <label> <input type="radio" name="status" value=" in-stock" @if(old('status')=='in-stock') checked @endif> In Stock</label>
            <label> <input type="radio" name="status" value="sold-out"  @if(old('status')=='sold-out') checked @endif> Sld Out</label>
            <label> <input type="radio" name="status" value="draft"  @if(old('status')=='draft') checked @endif>Draft</label>

        </div>
        @error('status')
        <p class="invalid-feedback d-block">{{$message}}</p>
                 @enderror
    </div>

    <div>
        <button type="submit" class="btn btn-primary">Add</button>
    </div>


</form>

@endsection
@section('css')
<link rel="stylesheet" href="{{asset('js/tagify/tagify.css')}}">
@endsection
@section('js')
<script src="{{asset('js/tagify/tagify.min.js')}}"></script>
<script>
var inputElm=document.querySelector('.tagify'),
tagify=new Tagify(inputElm);
</script>
@endsection

