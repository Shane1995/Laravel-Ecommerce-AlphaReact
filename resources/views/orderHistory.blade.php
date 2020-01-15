@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Orders Panel</h1>

    @if(session('orderDeletionStatus'))
    <div class="alert alert-danger"> {{session('orderDeletionStatus')}} </div>
    @endif



    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#order_id</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>user_id</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->order_id}}</td>
                    <td>{{$order->date}}</td>
                    <td>R{{$order->price}}</td>
                    <td>{{$order->user_id}}</td>
                    <td>{{$order->status}}</td>
                    <td><a href="{{route('orderItems',['id'=>$order->order_id])}}"
                            class="payment-info-button btn btn-primary"> View Items </a>
                    </td>
                </tr>


                @endforeach





            </tbody>
        </table>


        <div style="margin-top:15px;">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <a href="{{ route('AllProducts')}}" class="btn btn-warning" style="margin-right:15px;">Main Website </a>
            @if($userData->isAdmin())
            <a href="{{ route('adminDisplayProducts')}}" class="btn btn-primary">Admin Panel</a>
            @else

            @endif
        </div>

    </div>
</div>

@endsection