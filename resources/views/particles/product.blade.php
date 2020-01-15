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
                            <img src="{{Storage::disk('local')->url('products_images/'.$product->image)}}"
                                style="height:400px; width:400px;" alt="" />
                            <h2>R{{$product->price}}</h2>


                            <p>{{$product->brand}}</p>

                            <div class="card">
                                <div class="card-header">
                                    <p>{{$product->name}}</p>
                                </div>

                                <div class="card-body text-left">
                                    <p>{{$product->description}}</p>
                                </div>
                            </div>

                            <a href="{{route('AddToCartProduct',['id'=>$product->id])}}"
                                class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to
                                cart</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>

</body>

@endsection