@extends('layouts.main')

@section('content')

<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>dresses</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcumb Area End ##### -->

<!-- ##### Shop Grid Area Start ##### -->
<section class="shop_grid_area section-padding-80">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3">
                <div class="shop_sidebar_area">

                    <!-- ##### Single Widget ##### -->
                    <div class="widget catagory mb-50">
                        <!-- Widget Title -->
                        <h6 class="widget-title mb-30">Catagories</h6>

                        <!--  Catagories  -->
                        <div class="catagories-menu">
                            <ul id="menu-content2" class="menu-content collapse show">
                                <!-- Single Item -->
                                <li data-toggle="collapse" data-target="#clothing">
                                    <a href="#">Categories</a>
                                    <ul class="sub-menu collapse show" id="clothing">
                                        <li><a href="/">All</a></li>
                                        <li><a href="/dress">Dress</a></li>
                                        
                                        <li><a href="/jacket">Jacket</a></li>
                                        <li><a href="/jeans">Jeans</a></li>
                                        <li><a href="/pant">Pants &amp; Leggings</a></li>
                                        
                                        <li><a href="/shirt">Shirt &amp; Blouses</a></li>

                                   
                                    </ul>
                                </li>
                                
                            </ul>
                        </div>
                    </div>

                    <!-- ##### Single Widget ##### -->
                    <div class="widget price mb-50">
                        <!-- Widget Title -->
                        <h6 class="widget-title mb-30">Filter by</h6>
                        <!-- Widget Title 2 -->
                        <p class="widget-title2 mb-30">Price</p>

                        <div class="widget-desc">
                            <div class="slider-range">
                                <div data-min="49" data-max="360" data-unit="$" class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" data-value-min="49" data-value-max="360" data-label-result="Range:">
                                    <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                                    <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                    <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                </div>
                                <div class="range-price">Range: $49.00 - $360.00</div>
                            </div>
                        </div>
                    </div>

                    <!-- ##### Single Widget ##### -->
                    <div class="widget color mb-50">
                        <!-- Widget Title 2 -->
                        <p class="widget-title2 mb-30">Color</p>
                        <div class="widget-desc">
                            <ul class="d-flex">
                                <li><a href="#" class="color1"></a></li>
                                <li><a href="#" class="color2"></a></li>
                                <li><a href="#" class="color3"></a></li>
                                <li><a href="#" class="color4"></a></li>
                                <li><a href="#" class="color5"></a></li>
                                <li><a href="#" class="color6"></a></li>
                                <li><a href="#" class="color7"></a></li>
                                <li><a href="#" class="color8"></a></li>
                                <li><a href="#" class="color9"></a></li>
                                <li><a href="#" class="color10"></a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- ##### Single Widget ##### -->
                    <div class="widget brands mb-50">
                        <!-- Widget Title 2 -->
                        <p class="widget-title2 mb-30">Brands</p>
                        <div class="widget-desc">
                            <ul>
                                <li><a href="#">Asos</a></li>
                                <li><a href="#">Mango</a></li>
                                <li><a href="#">River Island</a></li>
                                <li><a href="#">Topshop</a></li>
                                <li><a href="#">Zara</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8 col-lg-9">
                <div class="shop_grid_product_area">
                    <div class="row">
                        <div class="col-12">
                            <div class="product-topbar d-flex align-items-center justify-content-between">
                                <!-- Total Products -->
                                <div class="total-products">
                                    <p><span>{{$total}}</span> products found</p>
                                </div>
                                <!-- Sorting -->
                                <div class="product-sorting d-flex">
                                    <p>Sort by:</p>
                                    <form action="#" method="get">
                                        <select name="select" id="sortByselect">
                                            <option value="value">Highest Rated</option>
                                            <option value="value">Newest</option>
                                            <option value="value">Price: $$ - $</option>
                                            <option value="value">Price: $ - $$</option>
                                        </select>
                                        <input type="submit" class="d-none" value="">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach($products as $product)
                        <!-- Single Product -->
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-product-wrapper">
                                <!-- Product Image -->
                                <div class="product-img">
                                    @if($product->image)
                                    <img src="/assets/img/product-img/{{$product->image}}" alt="">
                                    @else
                                    <img src="https://static.umotive.com/img/product_image_thumbnail_placeholder.png" alt="">
                                    @endif
                                    <!-- Hover Thumb -->
                                    <img class="hover-img" src="" alt="">

                                    <!-- Favourite -->
                                    <div class="product-favourite">
                                        <a href="#" class="favme fa fa-heart"></a>
                                    </div>
                                </div>

                                <!-- Product Description -->
                                <div class="product-description">
                                    <span>
                                        <a href="/products/{{$product->id}}">
                                            <h6>{{$product->product_name}}</h6>
                                        </a>
                                    </span>
                                    <p class="product-price">{{$product->selling_price}} <span>VND</span></p>

                                    <!-- Hover Content -->
                                    <div class="hover-content">
                                        <!-- Add to Cart -->
                                        <div class="add-to-cart-btn">
                                            <a href="#" class="btn essence-btn">Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Pagination -->
                
            </div>
        </div>
    </div>
</section>
<!-- ##### Shop Grid Area End ##### -->

@endsection