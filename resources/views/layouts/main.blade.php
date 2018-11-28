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

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="{{asset('../../assets/js/jquery/jquery-2.2.4.min.js')}}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}

</head>

<body>
    <!-- ##### Header Area Start ##### -->
    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="index.html"><img src="../../assets/img/core-img/logo.png" alt=""></a>
                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
                <!-- Menu -->
                <div class="classy-menu">
                    <!-- close btn -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <!-- Nav Start -->
                    <div class="classynav">
                        <ul>
                            <li><a href="#">Shop</a>
                                <div class="megamenu">
                                    <ul class="single-mega cn-col-4">
                                        <li class="title">Women's Collection</li>
                                        <li><a href="#">Dresses</a></li>
                                        <li><a href="#">Blouses &amp; Shirts</a></li>
                                        <li><a href="#">T-shirts</a></li>
                                        <li><a href="#">Rompers</a></li>
                                        <li><a href="#">Bras &amp; Panties</a></li>
                                    </ul>
                                    <ul class="single-mega cn-col-4">
                                        <li class="title">Men's Collection</li>
                                        <li><a href="#">T-Shirts</a></li>
                                        <li><a href="#">Polo</a></li>
                                        <li><a href="#">Shirts</a></li>
                                        <li><a href="#">Jackets</a></li>
                                        <li><a href="#">Trench</a></li>
                                    </ul>
                                    <ul class="single-mega cn-col-4">
                                        <li class="title">Kid's Collection</li>
                                        <li><a href="#">Dresses</a></li>
                                        <li><a href="#">Shirts</a></li>
                                        <li><a href="#">T-shirts</a></li>
                                        <li><a href="#">Jackets</a></li>
                                        <li><a href="#">Trench</a></li>
                                    </ul>
                                    <div class="single-mega cn-col-4">
                                        <img src="../../assets/img/bg-img/bg-6.jpg" alt="">
                                    </div>
                                </div>
                            </li>
                            <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="#">Home</a></li>
                                    <li><a href="#">Shop</a></li>
                                    <li><a href="#">Product Details</a></li>
                                    <li><a href="#">Checkout</a></li>
                                    <li><a href="#">Blog</a></li>
                                    <li><a href="#">Single Blog</a></li>
                                    <li><a href="#">Regular Page</a></li>
                                    <li><a href="#">Contact</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <!-- Search Area -->
                <div class="search-area">
                    <form action="#" method="post">
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
                    <a href="/user" id="account-menu-icon"><img src="../../assets/img/core-img/user.svg" alt=""></a>
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
                    <li><span>subtotal:</span> <span>$274.00</span></li>
                    <li><span>delivery:</span> <span>Free</span></li>
                    <li><span>discount:</span> <span>-15%</span></li>
                    <li><span>total:</span> <span>$232.00</span></li>
                </ul>
                <div class="checkout-btn mt-100">
                    <a href="checkout.html" class="btn essence-btn">check out</a>
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
                            <a href="#"><img src="../../assets/img/core-img/logo2.png" alt=""></a>
                        </div>
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <ul>
                                <li><a href="#">Shop</a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area mb-30">
                        <ul class="footer_widget_menu">
                            <li><a href="#">Order Status</a></li>
                            <li><a href="#">Payment Options</a></li>
                            <li><a href="#">Shipping and Delivery</a></li>
                            <li><a href="#">Guides</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Use</a></li>
                        </ul>
                    </div>
                </div>
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

                        </script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i>
                        by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
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
    {{-- <script src="{{asset('../../assets/js/plugins.js')}}"></script> --}}
    <!-- Classy Nav js -->
    <script src="{{asset('../../assets/js/classy-nav.min.js')}}"></script>
    <!-- Active js -->
    <script src="{{asset('../../assets/js/active.js')}}"></script>

    <script>
        
        var element = document.getElementById('account-menu-icon');
        var menu = document.getElementById('account-menu');
        var cart = document.getElementById("cart-list-items");

        var cartIcons = document.getElementsByClassName("cart-items-number");

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
                        temp.className = "single-cart-item";
                        temp.innerHTML =
                            '<a href="#" class="product-image">\
                                <img src=' + item.product_image + ' class="cart-thumb" alt="">\
                                <div class="cart-item-desc">\
                                    <span class="product-remove"><i class="fa fa-close" aria-hidden="true"></i></span>\
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
                   document.getElementById("stock-"+stock_id+"-quantity").innerHTML = response.item.quantity; 
                }
            })
        }

        function minus(stock_id) {
            $.ajax({
                url: "/cart/change",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { stock_id: stock_id, type: "minus" },
                success: function(response) {
                    console.log(response);
                    document.getElementById("stock-"+stock_id+"-quantity").innerHTML = response.item.quantity;
                }
            })
        }
        
    </script>

</body>

</html>
