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
                <form class="cart-form clearfix" method="post" name="formProduct" >
                    <!-- Select Box -->
                    <div class="select-box d-flex mt-50 mb-30">
                        <select name="productSize" id="productSize" class="mr-5" onchange="notify('size');">
                            <?php
                                for ($i = 0; $i < count($product->size); $i++) {
                                    echo "<option value='".$product->size[$i]."'>Size: ".$product->size[$i]."</option>";
                                }
                            ?>
                        </select>
                        <select name="productColor" id="productColor" onchange="notify('color');">
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
                        <button type="submit" name="addtocart"  class="btn essence-btn" id="addToCart">Add to cart</button>
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
        function notify(itemchanging) {
            <?php
            use Illuminate\Support\Facades\URL;
            $url = url('/')."/products/ajaxDetail";
            ?>
            var productId = <?php echo $product->id; ?>;
            var color = window.document.getElementById('productColor').value;
            var size = window.document.getElementById('productSize').value;
            $(document).ready(function(){
                $.ajax({
                    url:"/getPrice",
                    method:"GET",
                    async:true,
                    data:{color: color, size: size, id: productId, itemchanging: itemchanging },
                    success: function(response) {
                        if(response.selling_price != null) {
                            document.getElementById("addToCart").disabled = false;
                            $('#productPrice').empty().html(response.selling_price+ " VND");
                            $('#alert').empty();
                            if(response.color && response.color != null) {
                                var rewrite ='';
                                for(var i = 0; i < (response.color).length; i++ ) {
                                    rewrite+= "<option value='"+response.color[i]+"'>Color: "+response.color[i]+"</option>";
                                }
                                $('#productColor').empty().html(rewrite);
                            }
                        } else {
                            var message = "<?php echo $product->product_name; ?>"+" are no available with size "+size+" and color "+color;
                            $('#alert').html(message);
                            document.getElementById("addToCart").disabled = true;
                        } 
                        

                    }

                });
           });
        }
    </script>

@endsection
