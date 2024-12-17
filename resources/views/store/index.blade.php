<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title  -->
    <title>Amado - Furniture Ecommerce Template | Product Details</title>

    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('img/core-img/favicon.ico') }}">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>
    <!-- Search Wrapper Area Start -->
    <div class="search-wrapper section-padding-100">
        <div class="search-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search-content">
                        <form action="#" method="get">
                            <input type="search" name="search" id="search" placeholder="Type your keyword...">
                            <button type="submit"><img src="{{ asset('img/core-img/search.png') }}" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Wrapper Area End -->

    <!-- Main Content Wrapper Start -->
    <div class="main-content-wrapper d-flex clearfix">
        <!-- Mobile Nav (max width 767px)-->

        @include('layouts.mobile_header')

        <!-- Header Area Start -->

        @include('layouts.header')

        <!-- Header Area End -->

        <!-- Product Categories Area Start -->
        <div class="products-catagories-area clearfix">
            <div class="amado-pro-catagory clearfix">
                <!-- Repeatable Product Category Template -->
                <div class="single-products-catagory clearfix">
                    <a href="{{ url('store/shop') }}">
                        <img src="{{ asset('img/bg-img/1.jpg') }}" alt="">
                        <div class="hover-content">
                            <div class="line"></div>
                            <p>From $180</p>
                            <h4>Modern Chair</h4>
                        </div>
                    </a>
                </div>
                <div class="single-products-catagory clearfix">
                    <a href="{{ url('store/shop') }}">
                        <img src="{{ asset('img/bg-img/2.jpg') }}" alt="">
                        <div class="hover-content">
                            <div class="line"></div>
                            <p>From $180</p>
                            <h4>Modern Chair</h4>
                        </div>
                    </a>
                </div>
                <div class="single-products-catagory clearfix">
                    <a href="{{ url('store/shop') }}">
                        <img src="{{ asset('img/bg-img/3.jpg') }}" alt="">
                        <div class="hover-content">
                            <div class="line"></div>
                            <p>From $181</p>
                            <h4>Modern Chair</h4>
                        </div>
                    </a>
                </div>
                <div class="single-products-catagory clearfix">
                    <a href="{{ url('store/shop') }}">
                        <img src="{{ asset('img/bg-img/4.jpg') }}" alt="">
                        <div class="hover-content">
                            <div class="line"></div>
                            <p>From $180</p>
                            <h4>Modern Chair</h4>
                        </div>
                    </a>
                </div>
                <div class="single-products-catagory clearfix">
                    <a href="{{ url('store/shop') }}">
                        <img src="{{ asset('img/bg-img/5.jpg') }}" alt="">
                        <div class="hover-content">
                            <div class="line"></div>
                            <p>From $180</p>
                            <h4>Modern Chair</h4>
                        </div>
                    </a>
                </div>
                <div class="single-products-catagory clearfix">
                    <a href="{{ url('store/shop') }}">
                        <img src="{{ asset('img/bg-img/6.jpg') }}" alt="">
                        <div class="hover-content">
                            <div class="line"></div>
                            <p>From $180</p>
                            <h4>Modern Chair</h4>
                        </div>
                    </a>
                </div>
                
                <div class="single-products-catagory clearfix">
                    <a href="{{ url('store/shop') }}">
                        <img src="{{ asset('img/bg-img/7.jpg') }}" alt="">
                        <div class="hover-content">
                            <div class="line"></div>
                            <p>From $180</p>
                            <h4>Modern Chair</h4>
                        </div>
                    </a>
                </div>
                <div class="single-products-catagory clearfix">
                    <a href="{{ url('store/shop') }}">
                        <img src="{{ asset('img/bg-img/8.jpg') }}" alt="">
                        <div class="hover-content">
                            <div class="line"></div>
                            <p>From $180</p>
                            <h4>Modern Chair</h4>
                        </div>
                    </a>
                </div>
                <div class="single-products-catagory clearfix">
                    <a href="{{ url('store/shop') }}">
                        <img src="{{ asset('img/bg-img/9.jpg') }}" alt="">
                        <div class="hover-content">
                            <div class="line"></div>
                            <p>From $180</p>
                            <h4>Modern Chair</h4>
                        </div>
                    </a>
                </div>
                <!-- Add more products similarly -->
            </div>
        </div>
        <!-- Product Categories Area End -->
    </div>
    <!-- Main Content Wrapper End -->

    <!-- Footer Area Start -->

    @include('layouts.footer')

    <!-- Footer Area End -->

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="{{ asset('js/jquery/jquery-2.2.4.min.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <!-- Active js -->
    <script src="{{ asset('js/active.js') }}"></script>
</body>

</html>