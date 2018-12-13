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
                <h2>{{$product->product_name}}</h2>
                <div>
                    <span>{{$avg_rating}}</span> <i class="fa fa-star fa-2x"></i>
                </div>

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

        <div class="product-comments row">
            <div class="col-md-8">
                <h4>Bình luận</h4>
                <div>Có {{$num_of_comments}} bình luận về sản phẩm này</div>
                <div>
                    @foreach ($comments as $comment)
                        <div class="row comment">
                            <div class="col-md-2">
                                <img src="{{url('/')."/".$comment->user_avatar}}" width="100%"/>
                            </div>
                            <div class="col-md-10">
                                <div><b>{{$comment->user_first_name}} {{$comment->user_last_name}}</b></div>
                                <div>{{$comment->rating}} <i class="fa fa-star"></i>   {{$comment->created_at}}</div> 
                                <div>{{$comment->content}}</div>
                                <div class="mt-2" id="btn-reply-{{$comment->id}}">
                                    <a href="javascript:void(0);" onclick="reply({{$comment->id}});">Trả lời</a>
                                </div>
                                {{-- reply --}}
                                <div class="reply">
                                    @foreach ($comment->reply as $item)
                                        <div class="row comment">
                                            <div class="col-md-2">
                                                <img src="{{url('/')."/".$item->user_avatar}}" width="100%"/>
                                            </div>
                                            <div class="col-md-10">
                                                <div><b>{{$item->user_first_name}} {{$item->user_last_name}}</b></div>
                                                <div>{{$item->rating}} <i class="fa fa-star"></i>   {{$item->created_at}}</div> 
                                                <div>{{$item->content}}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="mt-4" id="new-comment">
                        @if (Auth::id())
                            <b>Bình luận của bạn</b>
                            <form method="POST" action="{{url('/comment')}}">
                                @csrf
                                <input type="hidden" value="{{Auth::id()}}" name="data[user_id]"/>
                                <input type="hidden" value="{{$product->id}}" name="data[product_id]"/>
                                <input type="hidden" name="data[rating]" id="rating-input" value="5"/>
                                <input type="hidden" name="data[parent_comment_id]" id="parent_comment_id"/>
                                <div class="mt-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star fa-2x star-rating selected" onclick="rate({{$i}})" id="rating-{{$i}}"></i>
                                    @endfor
                                </div>
                                <div class="form-group mt-2">
                                    <textarea class="form-control" placeholder="Viết bình luận của bạn..." name="data[content]"></textarea>
                                </div>
                                <button class="btn btn-primary float-right">Gửi</button>
                            </form>
                        @else
                            <b>Bạn cần đăng nhập để bình luận. <a href="{{url('/').'/login'}}">Đăng nhập ngay</a></b>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var stock_id = $("#stock_id"); 
        var product_id = {{$product->id}};
        var color = document.getElementById('productColor');
        var size = document.getElementById('productSize');
        var rating = document.getElementById('rating-input');
        var ratingStars = Array.prototype.slice.call(document.getElementsByClassName("star-rating"));
        var commentForm = document.getElementById("new-comment");

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
        
        function rate(i) {
            console.log(i);
            rating.value = i;

            ratingStars.map((item, index) => {
                console.log(index)
                if(index + 1 <= i) {
                    item.classList.remove("far");
                    item.classList.add("selected", "fas");
                } else {
                    item.classList.remove("selected", "fas");
                    item.classList.add("far");
                }
            })
        }

        function reply(i) {
            var form = commentForm.cloneNode(true);
            var temp = form.querySelectorAll('[id=parent_comment_id]');
            temp[0].value = i;
            document.getElementById(`btn-reply-${i}`).parentElement.append(form);
        }

    </script>

@endsection
