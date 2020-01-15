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

                    <th>item_id</th>
                    <th>order_id</th>
                    <th>item_name</th>
                    <th>item_price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>

                    <td>{{$order->item_id}}</td>
                    <td>{{$order->order_id}}</td>
                    <td>{{$order->item_name}}</td>
                    <td>R{{$order->item_price}}</td>

                </tr>


                @endforeach





            </tbody>
        </table>


        <div style="margin-top:15px;">
            <a href="{{route('orderHistory')}}" class="btn btn-danger">Back</a>
        </div>

    </div>
</div>

@endsection