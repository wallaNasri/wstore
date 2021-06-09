@extends('layouts.dashboard')
@section('title','Edite product')
@section('content')


<form action="{{route('products.update', $id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="form-group mb-3">
        <label for="">Name:</label>
        <input type="text" name="name" value="{{$product->name}}" class="form-control @error('name') is-invalid @enderror ">
        @error('name')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Category:</label>
        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
            <option value="">Select Category</option>
            @foreach ($categories as $category)
            <option value="{{$category->id}}" @if($category->id==$product->category_id) selected @endif >{{$category->name}}</option>

            @endforeach

        </select>
        @error('category_id')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>



    <div class="form-group mb-3">
        <label for="">Descrition:</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror"> {{$product->description}} </textarea>
        @error('description')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Image:</label>
        <div class="mb-2">
            <img src="{{ $product->image_url}}" height="200" alt="">
        </div>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
        @error('image')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Gallery:</label>
        <div class="row">
            @foreach($product->images as $image)
            <div class="col-md-2">
                <img src="{{ $image->image_url}}" height="80" class="img-fit m-1 border p-1">
            </div>
            @endforeach
        </div>
        <input type="file" name="gallery[]" multiple class="form-control @error('gallery') is-invalid @enderror">
        @error('gallery')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Price:</label>

        <input type="number" name="price" value="{{ $product->price}}" class="form-control @error('price') is-invalid @enderror">
        @error('price')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Sale Price:</label>
        <input type="number" name="sale_price" value="{{ $product->sale_price}}" class="form-control @error('sale_price') is-invalid @enderror">
        @error('sale_price')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Quantity:</label>
        <input type="number" name="quantity" value="{{ $product->quantity}}" class="form-control @error('quantity') is-invalid @enderror">
        @error('quantity')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Tags:</label>
        <input type="text" name="tags" value="{{$tags}}" class=" tagify form-control @error('tags') is-invalid @enderror">
        @error('tags')
        <p class="invalid-feedback">{{$message}}</p>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="">Status:</label>
        <div>
            <label> <input type="radio" name="status" value="in-stock" @if($product->status=='in-stock') checked @endif> In Stock</label>
            <label> <input type="radio" name="status" value="sold-out" @if($product->status=='sold-out') checked @endif> Sold Out</label>
            <label> <input type="radio" name="status" value="draft" @if($product->status=='draft') checked @endif> Draft</label>

        </div>
        @error('status')
        <p class="invalid-feedback d-block">{{$message}}</p>
        @enderror
    </div>

    <div>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>


</form>
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('js/tagify/tagify.css')}}">
@endsection
@section('js')
<script src="{{asset('js/tagify/tagify.min.js')}}"></script>
<script>
    var inputElm = document.querySelector('.tagify'),
        tagify = new Tagify(inputElm);
</script>
@endsection