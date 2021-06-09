@extends('layouts.dashboard')
@section('title','Product List')
@section('content')


<x-alert/>

<div class="table-toolbar mb-3">
<a href="{{route('products.create')}}" class="btn btn-info">Create</a>
</div>



<form action="{{url()->current()}}" method="get" class="d-flex mb-4">
    <input type="text" name="name" class="form-control me-2" placeholder="search by name">
    <select name="parent_id" class="form-control me-2">
        <option value="">All Products</option>
        @foreach ($categories as $category)
        <option value="{{$category->id}}">{{ $category->name}}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-secondary">Filter</button>

</form>


<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Parent ID</th>
            <th>Created At</th>
            <th>Status</th>
            <th></th>

        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{$product->id}}</td>
            <td><a href="{{route('products.edit',[$product->id])}}">{{$product->name}}</a></td>
            <td>{{$product->category->name}}</td>
            <td>{{$product->created_at}}</td>
            <td>{{$product->status}}</td>
            <td>
                <form action="{{route('products.destroy',$product->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>
{{$products->links()}}
@endsection
