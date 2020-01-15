@extends('layouts.admin')
@section('body')

<h1>Users</h1>

@if(session('orderDeletionStatus'))
<div class="alert alert-danger"> {{session('orderDeletionStatus')}} </div>
@endif
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#id</th>

                <th>Name</th>
                <th>Last Name</th>
                <th>email</th>
                <th>Joined On</th>

            </tr>
        </thead>
        <tbody>


            @foreach($users as $user)
            <tr>
                <td>{{$user['id']}}</td>


                <td>{{$user['name']}}</td>
                <td>{{$user['lastName']}}</td>
                <td>{{$user['email']}}</td>

                <td>{{$user['created_at']}}</td>
                <td><a href="{{route('displayUserOrder',['id'=>$user['id']])}}" class="btn btn-success">View User
                        Orders</a></td>

                @if($user['admin']==1)
                @if($user['id'] == Auth::user()->id)
                <td> </td>
                @else
                <td> <a href="{{route('removeAdmin',['id'=>$user['id']])}}"
                        onclick="return confirm('Are you sure you want to remove this user ({{$user['name']}} {{$user['lastName']}}) as Admin?')"
                        class="btn btn-danger">Remove Admin</a></td>
                @endif

                @else
                <td><a href="{{route('addAdmin',['id'=>$user['id']])}}"
                        onclick="return confirm('Are you sure you want to add this user ({{$user['name']}} {{$user['lastName']}}) as Admin?')"
                        class="btn btn-primary">Add As Admin</a></td>
                @endif
                <td><a href="{{route('removeUser',['id'=>$user['id']])}}"
                        onclick="return confirm('Are you sure you want to add this user ({{$user['name']}} {{$user['lastName']}}) as Admin?')"
                        class="btn btn-warning">Remove</a>
                </td>

            </tr>
            @endforeach


        </tbody>
    </table>



</div>
@endsection