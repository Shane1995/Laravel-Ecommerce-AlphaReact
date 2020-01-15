<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google analytics -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-147755764-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-147755764-1');
    </script>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/responsive.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{asset('images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{asset('images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{asset('images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="{{asset('images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('images/ico/apple-touch-icon-57-precomposed.png')}}">
</head>
<!--/head-->

<body>

    <div class="header-middle">
        <!--header-middle-->
        <div class="container">
            <div class="row top-header">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="{{route('AllProducts')}}">
                            <h2>{{config('app.name', 'Laravel')}}</h2>
                        </a>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            @if(Auth::check())

                            <li><a href="{{route('cartProducts')}}">

                                    <i class="fa fa-shopping-cart"></i>

                                    @if(Session::has('cart'))
                                    <span class="cart-with-numbers">
                                        {{Session::get('cart')->totalQuantity}}
                                    </span>
                                    @endif

                                    Cart</a>
                            </li>
                            <li><a href="{{route('home')}}"><i class="fa fa-home"></i>Profile</a></li>
                            <li><a href="{{route('orderHistory')}}"><i class="fa fa-check-square-o"></i>Order
                                    History</a></li>
                            @else
                            <li><a href="/login"><i class="fa fa-lock"></i>Login</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--/header-middle-->