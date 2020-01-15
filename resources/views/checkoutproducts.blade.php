@extends('layouts.index')



@section('center')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Shopping Cart</li>
                <li class="active">Checkout</li>
            </ol>
        </div>




        @if(Auth::check())

        <div class="shopper-informations">
            <div class="row">

                <div class="col-sm-12">
                    <div class="bill-to">
                        <p> Shipping/Bill To</p>
                        <div class="form-one">
                            <form action="{{route('createNewOrder')}}" method="post">
                                {{csrf_field()}}
                                <label for="email">Email: </label>
                                <input type="text" name="email" placeholder="Email*" value="{{Auth::user()->email}}">
                                @error('email')
                                <div class="alert alert-success">{{$message}}</div>
                                @enderror
                                <label for="first_name">First Name: </label>
                                <input type="text" name="first_name" placeholder="First Name"
                                    value="{{Auth::user()->name}}" required>
                                @error('first_name')
                                <div class="alert alert-success">{{$message}}</div>
                                @enderror

                                <label for=" last_name">Last Name: </label>
                                <input type="text" name="last_name" placeholder="Last Name"
                                    value="{{Auth::user()->lastName}}">
                                @error('last_name')
                                <div class="alert alert-success">{{$message}}</div>
                                @enderror

                                <label for="address">Address : </label>
                                <input type="text" name="address" placeholder="Address *">
                                @error('address')
                                <div class="alert alert-success">{{$message}}</div>
                                @enderror

                                <label for="zip">Zip / Postal Code: </label>
                                <input type="text" name="zip" placeholder="Zip / Postal Code *">
                                @error('zip')
                                <div class="alert alert-success">{{$message}}</div>
                                @enderror
                                <label for="phone">Phone: </label>

                                <input type="text" name="phone" placeholder="Phone *">
                                @error('phone')
                                <div class="alert alert-success">{{$message}}</div>
                                @enderror
                                <button class="btn btn-success check_out" type="submit" name="submit">Proceed To
                                    Payment</button>
                            </form>
                        </div>
                        <div class="form-two">

                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
</section>
<!--/#cart_items-->

<section id="do_action">
    <div class="container">

        @else
        <div class="alert alert-danger" role="alert">
            <strong>Please!</strong> <a href="{{route('login') }}">Log in</a> in order to create an order
        </div>
        @endif
    </div>
</section>
<!--/#do_action-->


@endsection