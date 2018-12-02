@extends('layouts.main')

@section('content')
    <div class="container">
        <!-- ##### Single Product Details Area Start ##### -->
        <section class="single_product_details_area d-flex align-items-center">

            <!-- Single Product Thumb -->
            <div class="single_product_thumb clearfix">
                <div class="product_thumbnail_slides owl-carousel">
                        @foreach ($product->images as $image)
                            <img src="{{url("/")."/".$image->source}}" alt="Product Image"/>
                        @endforeach
                        <img src="https://soliloquywp.com/wp-content/uploads/2016/08/How-to-Set-a-Default-Featured-Image-in-WordPress.png" alt="Product Image"/>
                    
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
                <div class="cart-form clearfix" >
                    <!-- Select Box -->
                    <div class="select-box d-flex mt-50 mb-30">
                        <select name="productSize" id="productSize" class="mr-5" onchange="changeSize();">
                            @foreach ($product->sizes as $size)
                                <option value="{{$size->id}}">{{$size->name}}</option>
                            @endforeach
                        </select>
                        <select name="productColor" id="productColor" onchange="changeColor();">
                            @foreach ($product->colors as $color)
                                <option value="{{$color->id}}">{{$color->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Cart & Favourite Box -->
                    <div class="cart-fav-box d-flex align-items-center">
                        <!-- Cart -->
                        <form id="addtocart" method="POST" action="{{url('/cart')}}">
                            @csrf
                            <input type="hidden" name="stock_id" id="stock_id" value="{{$current_stock}}"/>
                            <button type="submit" class="btn essence-btn" id="cart-btn">
                                Add to cart
                            </button>
                        </form>
                        <!-- Favourite -->
                        <div class="product-favourite ml-4">
                            <a href="#" class="favme fa fa-heart"></a>
                        </div>
                    </div>
                </div>
                <div id='alert'></div>
            </div>
        </section>
        <!-- ##### Single Product Details Area End ##### -->
    </div>
    <script>
        var stock_id = $("#stock_id"); 
        var product_id = {{$product->id}};
        var color = document.getElementById('productColor');
        var size = document.getElementById('productSize');
        
        function changeSize() {
            $(document).ready(function(){
                $.ajax({
                    url: "/product/colors",
                    method: "GET",
                    async: true,
                    data: { size_id: size.value, product_id: product_id },
                    success: function(response) {
                        stock_id.val(response.current_stock);
                        $('#productPrice').empty().html(response.selling_price+ " VND");
                        if(response.colors && response.colors != null) {
                            var rewrite ='';
                            for(var i = 0; i < (response.colors).length; i++ ) {
                                rewrite+= "<option value='"+response.colors[i].id+"'>"+response.colors[i].name+"</option>";
                            }
                            $('#productColor').empty().html(rewrite);
                        }
                    }
                });
            });
        }

        function changeColor() {
            $(document).ready(function(){
                $.ajax({
                    url: "/product/price",
                    method: "GET",
                    async: true,
                    data: { color_id: color.value, size_id: size.value, product_id: product_id },
                    success: function(response) {
                        stock_id.val(response.current_stock);
                        $('#productPrice').empty().html(response.selling_price+ " VND");
                    }
                });
            });
        }
    </script>

@endsection
