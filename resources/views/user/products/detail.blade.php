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
                <p class="product-price" id="productPrice">{{$product->selling_price}} VND</p>
                <p class="product-desc">{!!$product->description!!}</p>

                <!-- Form -->
                <form class="cart-form clearfix" method="post" name="formProduct">
                    <!-- Select Box -->
                    <div class="select-box d-flex mt-50 mb-30">
                        <select name="productSize" id="productSize" class="mr-5" onchange="notify(window.document.formProduct.productSize.value);">
                            <?php
                                for ($i = 0; $i < count($product->size); $i++) {
                                    echo "<option value='".$product->size[$i]."'>Size: ".$product->size[$i]."</option>";
                                }
                            ?>
                        </select>
                        <select name="productColor" id="productColor" onchange="notify(window.document.formProduct.productColor.value);">
                            <?php
                                for ($j = 0; $j < count($product->color); $j++) {
                                    echo "<option value='".$product->color[$j]."'>Color: ".$product->color[$j]."</option>";
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
                <div id='alert'></div>
            </div>
        </section>
        <!-- ##### Single Product Details Area End ##### -->
    </div>
    <script>
        function notify(attribute) {
            <?php
            use Illuminate\Support\Facades\URL;
            $url = url('/')."/products/ajaxDetail";
            ?>
            var productId = <?php echo $product->id; ?>;
            var color = window.document.formProduct.productColor.value;
            var size = window.document.formProduct.productSize.value;
            $(document).ready(function(){
                $.ajax({
                    url:"/getPrice",
                    method:"GET",
                    async:true,
                    data:{color: color, size: size, id: productId},
                    success: function(response) {
                        if(response != 0) {
                            $('#productPrice').empty().html(response+ " VND");
                            $('#alert').empty();
                        } else {
                            var message = 'Sorry, '+'<?php echo $product->product_name;?>'+'are no available with size '+size+' and color '+color;
                            $('#alert').empty().html(message);
                        }
                        

                    }

                });
           });
        }
    </script>

@endsection
