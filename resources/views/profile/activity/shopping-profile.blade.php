<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="User Profile Page">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Profile</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/core-img/favicon.ico') }}">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>
    <!-- Main Content Wrapper Start -->
    <div class="main-content-wrapper d-flex clearfix">
        <!-- Mobile Header -->
        @include('layouts.mobile_header')

        <!-- Header (Sidebar) -->
        @include('layouts.header')

        <!-- Profile Section -->
        <div class="profile-content-area d-flex">
            <div class="container">
                <div class="row">
                    <!-- Profile Left Pane (Image) -->
                    <div class="col-12 col-md-4 col-lg-4 text-center text-md-start mb-3">
                        <img src="{{ asset('img/purchased-img/freeCodeCampLogo.jpg') }}" 
                             class="profile-img rounded-circle mb-3" 
                             alt="User Image">
                    </div>

                    <!-- Profile Right Pane (Details + Links) -->
                    <div class="col-12 col-md-8 col-lg-8">
                        <!-- Profile Information -->
                        <h2 class="profile-name">{{ $user->username }}</h2>
                        <p class="profile-bio">{{ $user->email }}</p>
                        
                        <!-- Account Links Section -->
                        <div class="d-flex justify-content-start justify-content-md-start mt-3">
                            <a href="/profile" class="btn btn-secondary mx-2">Edit Profile</a>
                            <a href="#orders" class="btn btn-primary mx-2">View Orders</a>
                            <a href="#wishlist" class="btn btn-outline-secondary mx-2">Wishlist</a>
                        </div>
                    </div>
                </div>

                <!-- Order History Section -->
                <div class="col-12 mt-5" id="orders">
                    <h3>Order History</h3>
                    <div class="orders-container">
                        <!-- Static Order Placeholder -->
                        <div class="single-order">
                            <p><strong>Order #12345</strong></p>
                            <p>Date: 10 Nov, 2024</p>
                            <p>Status: <span class="badge badge-success">Delivered</span></p>
                            <p>Total: $50.00</p>
                        </div>
                        <div class="single-order">
                            <p><strong>Order #12346</strong></p>
                            <p>Date: 8 Nov, 2024</p>
                            <p>Status: <span class="badge badge-warning">Pending</span></p>
                            <p>Total: $30.00</p>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Section -->
                <div class="col-12 mt-5" id="wishlist">
                    <h3>Wishlist</h3>
                    <div class="wishlist-container">
                        <!-- Static Wishlist Placeholder -->
                        <div class="single-wishlist-item">
                            <img src="{{ asset('img/products/product1.jpg') }}" alt="Wishlist Item" class="wishlist-img">
                            <p class="wishlist-title">Product Name 1</p>
                            <p class="wishlist-price">$20.00</p>
                            <a href="/product/1" class="btn btn-primary">View Product</a>
                        </div>
                        <div class="single-wishlist-item">
                            <img src="{{ asset('img/products/product2.jpg') }}" alt="Wishlist Item" class="wishlist-img">
                            <p class="wishlist-title">Product Name 2</p>
                            <p class="wishlist-price">$15.00</p>
                            <a href="/product/2" class="btn btn-primary">View Product</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Area -->
        @include('layouts.footer')
    </div>
    <!-- Main Content Wrapper End -->

    <!-- jQuery -->
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
