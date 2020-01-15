@extends('layouts.index')

@section('center')


<div class="container">
    @include('alert')
</div>


<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Category</h2>
                    <div class="panel-group category-products" id="accordian">
                        <!--category-productsr-->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a href="{{route('AllProducts')}}">
                                    <span class="badge pull-right"></span>
                                    All Products
                                </a>
                            </div>
                            @for($i = 0; $i < count($type[0]); $i++) <div class="panel-heading">

                                <a href="{{route('getCategoryProducts',['cat'=> $type[0][$i]->type])}}">
                                    <span class="badge pull-right"></span>
                                    {{ $type[0][$i]->type}}
                                </a>

                        </div>
                        @endfor
                    </div>


                </div>


                <!--/category-products-->

                <div class="brands_products">
                    <!--brands_products-->
                    <h2>Brands</h2>
                    <div class="brands-name">
                        <ul class="nav nav-pills nav-stacked">
                            @for($i = 0; $i < count($brands[0]); $i++) <li><a
                                    href="{{route('getBrandsProducts',['brand'=> $brands[0][$i]->brand])}}">
                                    {{ $brands[0][$i]->brand}}</a></li>
                                @endfor
                        </ul>
                    </div>
                </div>
                <!--/brands_products-->




            </div>
        </div>

        @yield('products')
        <!--features_items-->


        <!--/category-tab-->



    </div>
    </div>
    </div>
</section>

@endsection