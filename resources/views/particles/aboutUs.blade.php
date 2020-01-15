@extends('allproducts')

@section('products')


<body>

    <div class="col-sm-9 padding-right">
        <div class="search_box pull-right">
            <form action="/search" method="get">
                <input type="text" name="searchText" placeholder="Search" />
            </form>
        </div>
        <div class="features_items">
            <!--features_items-->
            <h2 class="title text-center">Features Items</h2>



            <div class="col-sm-12">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">

                        </div>
                    </div>

                </div>
            </div>

        </div>

</body>

@endsection