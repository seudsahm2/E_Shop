<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="{{ asset('css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>
    <!-- Main Content Wrapper Start -->
    <div class="main-content-wrapper d-flex clearfix">
        @include('layouts.mobile_header')
        @include('layouts.header')
        <!-- Sidebar Area Start -->
        @include('layouts.sidebar')
        <!-- Sidebar Area End -->

        <!-- Product Area Start -->
        <div class="amado_product_area section-padding-100">
            <div class="container-fluid">
                <!-- Products Row -->
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                        <div class="single-product-wrapper">
                            <div class="product-img">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            </div>
                            <div class="product-description d-flex align-items-center justify-content-between">
                                <div class="product-meta-data">
                                    <div class="line"></div>
                                    <p class="product-price">${{ $product->price }}</p>
                                    <a href="{{ route('product.show', $product->id) }}">
                                        <h4>{{ $product->name }}</h4>
                                    </a>
                                </div>
                                <div class="ratings-cart text-right">
                                    <div class="ratings">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </div>
                                    <div class="cart">
                                        <a href="#" class="add-to-cart-btn" data-id="{{ $product->id }}" data-quantity="1" data-url="{{ route('cart.add', $product->id) }}" data-token="{{ csrf_token() }}">
                                            <img src="{{ asset('img/core-img/cart.png') }}" alt="Add to Cart">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="navigation">
                            <ul class="pagination justify-content-end mt-50">
                                {{ $products->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Area End -->
    </div>
    <!-- Main Content Wrapper End -->

    <!-- Newsletter Area Start -->
    <section class="newsletter-area section-padding-100-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="newsletter-text mb-100">
                        <h2>Subscribe to our Newsletter</h2>
                        <p>Subscribe to our newsletter and get 10% off your first purchase.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-5">
                    <div class="newsletter-form mb-100">
                        <form action="#" method="post">
                            <input type="email" name="email" class="nl-email" placeholder="Your E-mail">
                            <button type="submit" class="btn amado-btn">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')
    <!-- Newsletter Area End -->

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

            addToCartButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    var productId = this.getAttribute('data-id');
                    var quantity = this.getAttribute('data-quantity');
                    var url = this.getAttribute('data-url');
                    var token = this.getAttribute('data-token');

                    var formData = new FormData();
                    formData.append('_token', token);
                    formData.append('quantity', quantity);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', url, true);

                    xhr.setRequestHeader('X-CSRF-TOKEN', token);

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var response = JSON.parse(xhr.responseText);

                            if (response.message) {
                                alert(response.message);
                            }
                        } else if (xhr.readyState == 4) {
                            alert("Failed to add product to cart");
                        }
                    };
                    xhr.send(formData);
                });
            });
        });
    </script>
</body>

</html>