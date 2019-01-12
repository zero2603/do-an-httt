@extends('layouts.main')

@section('content')

<!-- ##### Breadcumb Area Start ##### -->
<div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
    <div class="container h-100" style="background: url('https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/hbz-the-list-maxi-dresses-00-index-1531251147.jpg?crop=5.5xw:1.00xh;0,0&resize=500:*');">
        <div class="row h-100 align-items-center" >
            <div class="col-12">
                <div class="page-title text-center">
                    <h2 style="color: green">New Arrival</h2>
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

                        <!--  Catagories  -->
                        <div class="catagories-menu">
                            <ul id="menu-content2" class="menu-content collapse show">
                                <!-- Single Item -->
                                <li>
                                    <a>Danh mục</a>
                                    <form>
                                        <ul class="sub-menu collapse show" id="clothing-categories">
                                        </ul>
                                    </form>
                                </li>
                                <li>
                                    <a>Màu sắc</a>
                                    <form>
                                        <ul class="sub-menu collapse show" id="clothing-colors">
                                        </ul>
                                    </form>
                                </li>
                                <li>
                                    <a>Size</a>
                                    <form>
                                        <ul class="sub-menu collapse show" id="clothing-sizes">
                                        </ul>
                                    </form>
                                </li>
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
                                            <!-- <option value="value">Highest Rated</option> -->
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
                                    <img src="{{$product->image}}" alt="">
                                    @else
                                    <img src="{{url("/")."/assets/img/product_image_placeholder.png"}}" alt="">
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
                                    {{-- <div class="hover-content">
                                        <!-- Add to Cart -->
                                        <div class="add-to-cart-btn">
                                            <a href="#" class="btn essence-btn">Add to Cart</a>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Pagination -->
                <nav aria-label="navigation">
                    {{ $products->links() }}
                </nav>
            </div>
        </div>
    </div>
</section>
<script>
    var url = new URL(window.location.href);
    var urlParams = new URLSearchParams(url.search.slice(1));

    $(document).ready(function(){
        $.ajax({
            url: "/categories",
            method: "GET",
            async: true,
            success: function(response) {
                response.categories.forEach(category => {
                    $('#clothing-categories').append(
                        `<li>
                            <input type="checkbox" name="category_id" value="${category.id}" ${(urlParams.getAll('category_id').indexOf(category.id.toString()) >= 0) ? "checked" : ""} onclick="query(this);"/> ${category.name}
                        </li>`
                    );
                })
                
            }
        });

        $.ajax({
            url: "/colors",
            method: "GET",
            async: true,
            success: function(response) {
                response.colors.forEach(color => {
                    $('#clothing-colors').append(
                        `<li>
                            <input type="checkbox" name="color_id" value="${color.id}" ${(urlParams.getAll('color_id').indexOf(color.id.toString()) >= 0) ? "checked" : ""} onclick="query(this);"/> ${color.name}
                        </li>`
                    );
                })
                
            }
        });

        $.ajax({
            url: "/sizes",
            method: "GET",
            async: true,
            success: function(response) {
                response.sizes.forEach(size => {
                    $('#clothing-sizes').append(
                        `<li>
                            <input type="checkbox" name="size_id" value="${size.id}" ${(urlParams.getAll('size_id').indexOf(size.id.toString()) >= 0) ? "checked" : ""} onclick="query(this);"/> ${size.name}
                        </li>`
                    );
                })
                
            }
        });
    });

    function query(item) {
        
        if(item.checked) {
            urlParams.append(item.name, item.value);
        } else {
            urlParams.delete(item.name, item.value);
        }
        
        window.location.href = window.location.origin + '/?' + urlParams.toString();
    }

</script>

@endsection