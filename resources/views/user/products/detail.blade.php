@extends('layouts.main')

@section('content')

    <div class="container">
        <!-- ##### Single Product Details Area Start ##### -->
        <section class="single_product_details_area d-flex align-items-center">

            <!-- Single Product Thumb -->
            <div class="single_product_thumb clearfix">
                <div class="product_thumbnail_slides owl-carousel">
                    <img src="../assets/img/product-img/{{$product->image}}" alt="">
                    <img src="../assets/img/product-img/{{$product->image}}" alt="">
                </div>
            </div>

            <!-- Single Product Description -->
            <div class="single_product_desc clearfix">
                <span></span>
                <a href="#">
                    <h2>{{$product->product_name}}</h2>
                </a>
                <p class="product-price">{{$product->selling_price}} VND</p>
                <p class="product-desc">{!!$product->description!!}</p>

                <!-- Form -->
                <form class="cart-form clearfix" method="post">
                    <!-- Select Box -->
                    <div class="select-box d-flex mt-50 mb-30">
                        <select name="select" id="productSize" class="mr-5">
                            <?php
                                for ($i = 0; $i < count($product->size); $i++) {
                                    echo "<option value='value'>Size: ".$product->size[$i]."</option>";
                                }
                            ?>
                        </select>
                        <select name="select" id="productColor">
                            <?php
                                for ($j = 0; $j < count($product->color); $j++) {
                                    echo "<option value='value'>Size: ".$product->color[$j]."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <!-- Cart & Favourite Box -->
                    <div class="cart-fav-box d-flex align-items-center">
                        <!-- Cart -->
                        <button type="submit" name="addtocart" value="5" class="btn essence-btn">Add to cart</button>
                        <!-- Favourite -->
                        <div class="product-favourite ml-4">
                            <a href="#" class="favme fa fa-heart"></a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!-- ##### Single Product Details Area End ##### -->
    </div>

@endsection
