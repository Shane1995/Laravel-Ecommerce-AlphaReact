@extends('layouts.index')



@section('center')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="#">Shopping Cart</li>
                <li>Checkout</li>
                <li class="#">Payment </li>
            </ol>
        </div>
        <section id="do_action">
            <div class="container">
                <div class="heading">
                    <p> Current Exchange rates are applied to convert Rands to dollars
                        when paying with paypal</p>
                    <p> Payments are not real for the meantime</p>
                    <p> Shipping/Bill To</p>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="total_area">
                            <ul>

                                <li>Payment Status
                                    @if($payment_info['status'] == 'on_hold')

                                    <span>not paid yet</span>

                                    @endif

                                </li>
                                <li>Shipping Cost <span>Free</span></li>
                                <li>Total <span>{{$payment_info['price']}}</span></li>
                            </ul>
                            <a class="btn btn-danger" href="{{route('AllProducts')}}">Cancel</a>
                            <a class="btn btn-success" id="paypal-button"></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
<!--/#payment-->







@endsection



<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
paypal.Button.render({
    // Configure environment
    env: 'sandbox',
    client: {
        sandbox: 'AWpHSg6rKcDOGHryouTvu33Y_ZWnZNka3RLjOdOJ-_r9aazeiewLkJKUtftNmLtsVjb25k59aUOAIexq'
    },
    // Customize button (optional)
    locale: 'en_US',
    style: {
        size: 'small',
        color: 'gold',
        shape: 'pill',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // Set up a payment
    payment: function(data, actions) {
        return actions.payment.create({
            transactions: [{
                amount: {
                    total: "{{$payment_info['price']*0.06}}",
                    currency: 'USD'
                },

            }]

        });
    },
    // Execute the payment
    onAuthorize: function(data, actions) {
        return actions.payment.execute().then(function() {
            // Show a confirmation message to the buyer
            window.alert('Thank you for your purchase!');

            window.location =
                "{{url('payment.paymentreceipt')}}" + "/" + data.paymentID + '/' + data.payerID;

        });
    }
}, '#paypal-button');
</script>