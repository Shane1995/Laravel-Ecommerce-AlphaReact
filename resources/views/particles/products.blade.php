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
            <h2 class="title text-center">Products</h2>


            @foreach($products as $product)
            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <a href="{{route('getProduct',['id'=>$product->id])}}"> <img class="product"
                                    src="{{Storage::disk('local')->url('products_images/'.$product->image)}}"
                                    style="height:220px; width:220px;" alt="" /> </a>
                            <h2>R{{$product->price}}</h2>
                            <p>{{$product->name}}</p>
                            <p>{{$product->brand}}</p>
                            <a href="{{route('AddToCartProduct',['id'=>$product->id])}}"
                                class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to
                                cart</a>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
        {{$products->links()}}
</body>

@endsection