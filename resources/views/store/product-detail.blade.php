<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title  -->
    <title>Amado - Furniture Ecommerce Template | {{ $product->name }}</title>

    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('img/core-img/favicon.ico') }}">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        <!-- Mobile Nav -->
        @include('layouts.mobile_header')

        <!-- Header Area -->
        @include('layouts.header')

        <!-- Product Details Area -->
        <div class="single-product-area section-padding-100 clearfix">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-50">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Category</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-7">
                        <div class="single_product_thumb">
                            <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <a class="gallery_img" href="{{ asset('storage/' . $product->image) }}">
                                            <img class="d-block w-100" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="single_product_desc">
                            <!-- Product Meta Data -->
                            <div class="product-meta-data">
                                <div class="line"></div>
                                <p class="product-price">${{ $product->price }}</p>
                                <h6>{{ $product->name }}</h6>
                                <!-- Ratings & Review -->
                                <div class="ratings-review mb-15 d-flex align-items-center justify-content-between">
                                    <div class="ratings">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                    <div class="review">
                                        <a href="#">Write A Review</a>
                                    </div>
                                </div>
                                <!-- Availability -->
                                <p class="avaibility"><i class="fa fa-circle"></i> In Stock</p>
                            </div>

                            <div class="short_overview my-5">
                                <p>{{ $product->description }}</p>
                            </div>

                            <!-- Add to Cart Form -->
                            <form id="add-to-cart-form" class="cart clearfix" method="post" action="{{ route('cart.add', $product->id) }}">
                                @csrf
                                <div class="cart-btn d-flex mb-50">
                                    <p>Qty</p>
                                    <div class="quantity">
                                        <span class="qty-minus" onclick="var effect = document.getElementById('qty'); 
                                            var qty = effect.value; 
                                                if(!isNaN(qty) && qty > 1) 
                                                    effect.value--;
                                                    return false;">
                                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        </span>

                                        <input type="number" class="qty-text" id="qty" step="1"
                                            min="1" max="{{ $product->quantity }}" name="quantity" value="1">
                                        <span class="qty-plus" onclick="var effect = document.getElementById('qty'); 
                                        var qty = effect.value; if(!isNaN(qty) && qty < {{ $product->quantity }}) effect.value++; return false;">
                                            <i class="fa fa-caret-up" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <button type="submit" name="addtocart" value="{{ $product->id }}" class="btn amado-btn">Add to cart</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- Footer Area -->
    @include('layouts.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/jquery/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/active.js') }}"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
            e.preventDefault();
            var form = this;
            var formData = new FormData(form);

            var actionurl = form.getAttribute('action');
            // console.log(form);
            // foreach(formData as value => data) {
            //     console.log(value, " ", data);
            //     console.log(formData.get('quantity'));
            // }

            // console.log(actionurl);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', actionurl, true);

            xhr.setRequestHeader('X-CSRF-TOKEN',
                document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            );


            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.message) {
                        alert(response.message);
                    }
                } else if (xhr.readyState == 4) {
                    alert("failed to add product to cart");
                }

            };
            xhr.send(formData);

        })
    </script>
</body>

</html>