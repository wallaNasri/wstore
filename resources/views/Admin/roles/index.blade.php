@extends('layouts.dashboard')
@section('content')
@section('title','Roles List')



<x-alert/>

<div class="table-toolbar mb-3">
<a href="{{route('roles.create')}}" class="btn btn-info">Create</a>
</div>




<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Created At</th>
            <th></th>

        </tr>
    </thead>
    <tbody>
        @foreach($roles as $role)
        <tr>
            <td>{{$role->id}}</td>
            <td><a href="{{route('roles.edit',[$role->id])}}">{{$role->name}}</a></td>
            <td>{{$role->created_at}}</td>
            <td>
                <form action="{{route('roles.destroy',$role->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>
@endsection
