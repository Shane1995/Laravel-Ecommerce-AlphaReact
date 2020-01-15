@extends('layouts.admin')

@section('body')

<div class="container">
    <h1>User Orders</h1>

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
                    <td><a href="{{route('displayItems',['id'=>$order->order_id])}}"
                            class="payment-info-button btn btn-primary"> View Items </a>
                    </td>
                </tr>


                @endforeach





            </tbody>
        </table>


        <div style="margin-top:15px;">

            <a href="{{ route('displayUser')}}" class="btn btn-danger" style="margin-right:15px;">Back </a>



        </div>

    </div>
</div>

@endsection