<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>@yield('title')</title>

    <!-- Favicon  -->
    <link rel="icon" href="{{asset('../../assets/img/core-img/favicon.ico')}}">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{asset('../../assets/css/core-style.css')}}">
    <link rel="stylesheet" href="{{asset('../../assets/css/custom-front.css')}}">
    <link rel="stylesheet" href="{{asset('../../assets/style.css')}}">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="{{asset('../../assets/js/jquery/jquery-2.2.4.min.js')}}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
    <style>
        .footer_area .single_widget_area .footer_social_area a {
            color: #ffffff;
            display: inline-block;
            padding: 0 10px;
            font-size: 30px;
            padding-top: 76px;
        }
        .footer_area .single_widget_area .footer_social_area a:hover {
            color: #ff084e;
            
        }
        .footer_area {
            background-color: #4e4646;
                padding: 70px 0 0px;
        }
    </style>
</head>

<body>
    <!-- ##### Header Area Start ##### -->
    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="{{url('/')}}"><b>BK SHOP</b></a>
                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
                <!-- Menu -->
                
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <!-- Search Area -->
                <div class="search-area">
                    <form action="/search" method="get">
                        <input type="search" name="search" id="headerSearch" placeholder="Type for search">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
                <!-- Favourite Area -->
                <div class="favourite-area">
                    <a href="#"><img src="../../assets/img/core-img/heart.svg" alt=""></a>
                </div>
                <!-- User Login Info -->
                <div class="user-login-info">
                    <a href="/user/profile" id="account-menu-icon">
                        <img src="../../assets/img/core-img/user.svg" alt="">
                    </a>
                    <div class="d-none" id="account-menu">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Đăng ký') }}</a>
                                @endif
                            </li>
                        @else
                            <li>
                                <a>Profile cá nhân</a>
                            </li>
                            <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                     {{ __('Đăng xuất') }}
                                 </a>

                                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                     @csrf
                                 </form>
                            </li>
                        
                        @endguest
                    </div>
                </div>
                <!-- Cart Area -->
                <div class="cart-area">
                    <a href="#" id="essenceCartBtn">
                        <img src="../../assets/img/core-img/bag.svg" alt=""> 
                        <span class="cart-items-number"></span>
                    </a>
                </div>
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Right Side Cart Area ##### -->
    <div class="cart-bg-overlay"></div>

    <div class="right-side-cart-area">

        <!-- Cart Button -->
        <div class="cart-button">
            <a href="#" id="rightSideCart">
                <img src="../../assets/img/core-img/bag.svg" alt=""> 
                <span class="cart-items-number"></span>
            </a>
        </div>

        <div class="cart-content d-flex">

            <!-- Cart List Area -->
            <div class="cart-list" id="cart-list-items">
            </div>

            <!-- Cart Summary -->
            <div class="cart-amount-summary">

                <h2>Summary</h2>
                <ul class="summary-table">
                    <li><span>subtotal:</span> <span id="subtotal">$0</span></li>
                    <li><span>delivery:</span> <span>Free</span></li>
                    {{-- <li><span>discount:</span> <span>-15%</span></li> --}}
                    <li><span>total:</span> <span id="total">$0</span></li>
                </ul>
                <div class="checkout-btn mt-100">
                    <a href="{{url('/').'/checkout'}}" class="btn essence-btn">check out</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Right Side Cart End ##### -->

    @yield('content')
    @yield('content-profile')

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix">
        <div class="container">
            <div class="row">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area d-flex mb-30">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="#"><h3 style="color: white !important;">BK SHOP</h3></a>
                        </div>
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <ul>
                                <li><a href="contact.html" style="padding-top: 8px;">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                
            </div>

            <div class="row align-items-end">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_heading mb-30">
                            <h6>Subscribe</h6>
                        </div>
                        <div class="subscribtion_form">
                            <form action="#" method="post">
                                <input type="email" name="mail" class="mail" placeholder="Your email here">
                                <button type="submit" class="submit"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_social_area">
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook"
                                    aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Instagram"><i class="fa fa-instagram"
                                    aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter"
                                    aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Pinterest"><i class="fa fa-pinterest"
                                    aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Youtube"><i class="fa fa-youtube-play"
                                    aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());

                        </script> BK SHOP <i class="fa fa-heart-o" aria-hidden="true"></i>
                        by <a href="https://colorlib.com" target="_blank" style="color: #787878;">Group 11</a>
                       
                    </p>
                </div>
            </div>

        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    
    <!-- Popper js -->
    <script src="{{asset('../../assets/js/popper.min.js')}}"></script>
    <!-- Bootstrap js -->
    <script src="{{asset('../../assets/js/bootstrap.min.js')}}"></script>
    <!-- Plugins js -->
    <script src="{{asset('../../assets/js/plugins.js')}}"></script>
    <!-- Classy Nav js -->
    <script src="{{asset('../../assets/js/classy-nav.min.js')}}"></script>
    <!-- Active js -->
    <script src="{{asset('../../assets/js/active.js')}}"></script>

    <script>
        var rootUrl = "{{url('/')}}";
        var element = document.getElementById('account-menu-icon');
        var menu = document.getElementById('account-menu');
        var cart = document.getElementById("cart-list-items");

        var cartIcons = document.getElementsByClassName("cart-items-number");

        var subtotal = document.getElementById("subtotal");
        var total = document.getElementById("total");

        $(document).ready(function(){
            $.ajax({
                url: '/cart',
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(response){

                    Array.prototype.forEach.call(cartIcons, function(item) {
                        item.innerHTML = response.cart.length;
                    });

                    var items = [];
                    response.cart.forEach(item => {
                        let temp = document.createElement("div");
                        if(!item.product_image) {
                            image = "assets/img/product_image_placeholder.png";
                        } else {
                            image = item.product_image;
                        }

                        temp.className = "single-cart-item";
                        temp.innerHTML =
                            '<a href="#" class="product-image">\
                                <img src=' + rootUrl + '/' + image + ' class="cart-thumb" alt="">\
                                <div class="cart-item-desc">\
                                    <span class="product-remove"><i class="fa fa-close" aria-hidden="true" onclick="remove('+ item.stock_id +');"></i></span>\
                                    <h6>'+ item.product_name + '</h6>\
                                    <p class="size">Size: ' + item.size_name + '</p>\
                                    <p class="color">Color: ' + item.color_name  + '</p>\
                                    <div>\
                                        <span class="price">$' + item.selling_price + '</span>\
                                        <span class="price"> x </span>\
                                        <span class="price" id="stock-'+ item.stock_id +'-quantity">' + item.quantity + '</span>\
                                        <span class="ml-4">\
                                            <button class="change-quantity-btn" onclick="plus('+ item.stock_id + ');">+</button>\
                                        </span>\
                                        <span>\
                                            <button class="change-quantity-btn" onclick="minus(' + item.stock_id + ');">-</button>\
                                        </span>\
                                    </div>\
                                </div>\
                            </a>';
                        cart.appendChild(temp);      
                    })

                    subtotal.innerHTML = response.total;
                    total.innerHTML = response.total;
                }
            })
        });

        function plus(stock_id) {
            $.ajax({
                url: "/cart/change",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { stock_id: stock_id, type: "plus" },
                success: function(response) {
                    if(response.err) {
                        window.alert(response.err);
                    } else {
                        document.getElementById("stock-"+stock_id+"-quantity").innerHTML = response.item.quantity;
                        subtotal.innerHTML = response.total;
                        total.innerHTML = response.total;
                    }
                }
            })
        }

        function minus(stock_id) {
            var element = document.getElementById("stock-"+stock_id+"-quantity");
            if(element.innerHTML == 1) {
                window.alert("Mỗi sản phẩm phải có số lượng ít nhất là 1");
            } else {
                $.ajax({
                    url: "/cart/change",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { stock_id: stock_id, type: "minus" },
                    success: function(response) {
                        element.innerHTML = response.item.quantity;
                        subtotal.innerHTML = response.total;
                        total.innerHTML = response.total;
                    }
                })
            }
        }

        function remove(stock_id) {
            $.ajax({
                url: "/cart/" + stock_id,
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.result) {
                        window.location.reload();
                    } else {
                        window.alert("Đấ có lỗi xảy ra. Vui lòng thử lại");
                    }
                }
            })
        }
        
    </script>

</body>

</html>
