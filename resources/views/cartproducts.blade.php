@extends('layouts.index')

@section('center')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{route('AllProducts')}}">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>



                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>

                    @foreach($cartItems->items as $item)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img class="cartProducts" style="width:100px;height:100px;"
                                    src=" {{Storage::disk('local')->url('products_images/'.$item['data']['image'])}}"
                                    alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$item['data']['name']}}</a></h4>

                            <p>{{$item['data']['type']}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{$item['data']['price']}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up"
                                    href="{{route('increaseSingleProduct',['id'=>$item['data']['id']])}}"> + </a>
                                <input class="cart_quantity_input" type="text" name="quantity"
                                    value="{{$item['quantity']}}" autocomplete="off" size="2">
                                <a class="cart_quantity_down"
                                    href="{{route('decreaseSingleProduct',['id'=>$item['data']['id']])}}"> - </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">R{{$item['totalSinglePrice']}}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete"
                                href="{{route('deleteItemFromCart', ['id'=>$item['data']['id']])}}"><i
                                    class="fa fa-times"></i></a>
                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</section>
<!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>Would you like to buy your item/s?</h3>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="total_area">
                    <ul>
                        <li>Cart Sub Total <span> R {{$cartItems->totalPrice}} </span></li>
                        <li>Tax <span>R {{$cartItems->totalPrice * 0.15}} </span></li>
                        <li>Shipping Cost <span>Free</span></li>
                        <li>Total <span>R {{$cartItems->totalPrice * 0.15 + $cartItems->totalPrice}}</span></li>
                    </ul>

                    <a class="btn btn-danger back" href="{{route('AllProducts')}}">Back</a>
                    <span class="float-right"> <a href="{{ route('checkoutProducts') }}"
                            class="btn btn-success check_out" href="">Check
                            Out</a></span>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#do_action-->

@endsection