@extends('layouts.index')



@section('center')



@if(empty($payment_receipt['order_id']))

<div class="container">
    <h3> An Error has Occured </h3>
    <p> An error has occured while trying to display {{Auth::user()->name}} {{Auth::user()->lastName}}'s order details
    </p>
    <p>
        Please check your order history to confirm payment
    </p>
    <p> else, send us an <strong>Email</strong>:
        shanelinden1995@gmail.com</p>

    <p>
        or call us, <strong>Contact</strong>:
        0795991565
    </p>

    <div>

        <a href="{{route('AllProducts')}}">Back</a>
    </div>
</div>

@else


<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>

        <div class="shopper-informations">
            <div class="row">

                <div class="col-sm-12 clearfix" style="margin-bottom:20px">
                    <div class="bill-to">
                        <p> Payment Receipt</p>
                        <div class="form-one">

                            <h1 class="text-center"> Thanks for choosing our product!</h1>
                            <div class="total_area">
                                <ul>

                                    <li>Order ID<span>{{$payment_receipt['order_id']}}</span></li>
                                    <li>Payer ID<span>{{$payment_receipt['paypal_payer_id']}}</span></li>
                                    <li>Payment ID<span>{{$payment_receipt['paypal_payment_id']}}</span></li>
                                    <li>Total <span id="amount">{{$payment_receipt['price']}}</span></li>
                                </ul>
                                <a class="btn btn-default update" href="{{route('AllProducts')}}">Shop Again!</a>

                            </div>



                        </div>
                        <div class="form-two">

                        </div>


                    </div>


                </div>

            </div>
        </div>


    </div>
</section>
<!--/#payment-->

@endif

@endsection