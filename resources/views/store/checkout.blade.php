<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Amado - Furniture Ecommerce Template | Checkout</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/core-img/favicon.ico') }}">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

        <div class="cart-table-area section-padding-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="checkout_details_area mt-50 clearfix">
                            <div class="cart-title">
                                <h2>Checkout</h2>
                            </div>
                            <form id="checkout-form" action="{{ route('checkout.process')}}" method="post">
                                @csrf
                                <div class="row">
                                    <!-- First Name -->
                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name"
                                            value="{{ old('first_name', $user->first_name ?? '') }}" required>
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name"
                                            value="{{ old('last_name', $user->last_name ?? '') }}" required>
                                    </div>

                                    <!-- Company Name -->
                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control" id="company" name="company_name" placeholder="Company Name"
                                            value="{{ old('company_name', $profile->company_name ?? '') }}">
                                    </div>

                                    <!-- Email -->
                                    <div class="col-12 mb-3">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                            value="{{ old('email', $user->email ?? '') }}">
                                    </div>

                                    <!-- Country -->
                                    <div class="col-12 mb-3">
                                        <select class="form-control" id="country" name="country">
                                            @foreach($countryList as $countryCode => $countryName)
                                            <option value="{{ $countryCode }}"
                                                {{ old('country', $profile->country ?? '') == $countryCode ? 'selected' : '' }}>
                                                {{ e($countryName) }} <!-- Apply htmlspecialchars to ensure proper escaping -->
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <!-- Address -->
                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control" id="street_address" name="address" placeholder="Address"
                                            value="{{ old('address', $profile->address ?? '') }}">
                                    </div>

                                    <!-- City -->
                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control" id="city" name="town" placeholder="Town"
                                            value="{{ old('town', $profile->town ?? '') }}">
                                    </div>

                                    <!-- Zip Code -->
                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" id="zipCode" name="zipcode" placeholder="Zip Code"
                                            value="{{ old('zipcode', $profile->zipcode ?? '') }}">
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="col-md-6 mb-3">
                                        <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="Phone No"
                                            value="{{ old('phone_number', $profile->phone_number ?? '') }}">
                                    </div>

                                    <!-- Comment -->
                                    <div class="col-12 mb-3">
                                        <textarea name="comment" class="form-control w-100" id="comment" cols="30" rows="10" placeholder="Leave a comment about your order">{{ old('comment') }}</textarea>
                                    </div>
                                </div>
                                <div class="payment-method">
                                    <div class="custom-control custom-radio mr-sm-2">
                                        <input type="radio" class="custom-control-input" id="cod" name="payment_method" value="cod" checked>
                                        <label class="custom-control-label" for="cod">Cash on Delivery</label>
                                    </div>
                                    <div class="custom-control custom-radio mr-sm-2">
                                        <input type="radio" class="custom-control-input" id="paypal" name="payment_method" value="paypal">
                                        <label class="custom-control-label" for="paypal">Paypal <img class="ml-15" src="{{ asset('img/core-img/paypal.png') }}" alt=""></label>
                                    </div>
                                </div>
                                <div class="cart-btn mt-100">
                                    <button type="submit" class="btn amado-btn w-100">Pay and Order</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <!-- Cart Summary -->
                        <div class="cart-summary">
                            <h5>Cart Total</h5>
                            <ul class="summary-table">
                                <li><span>Subtotal:</span>
                                    <span id="cart-subtotal">
                                        ${{ number_format($cart->items->sum(function ($item) {
                                            return $item->product->price * $item->quantity;
                                        }), 2) }}
                                    </span>
                                </li>
                                <li><span>Delivery:</span>
                                    <span id="cart-delivery">${{ number_format($cart->delivery_fee, 2) }}</span>
                                </li>
                                <li><span>Total:</span>
                                    <span id="cart-total">
                                        ${{ number_format($cart->items->sum(function ($item) {
                                            return $item->product->price * $item->quantity;
                                        }) + $cart->delivery_fee, 2) }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Area Start -->
    <section class="newsletter-area section-padding-100-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="newsletter-text mb-100">
                        <h2>Subscribe for a <span>25% Discount</span></h2>
                        <p>Subscribe to our newsletter for updates and offers.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-5">
                    <div class="newsletter-form mb-100">
                        <form action="#" method="post">
                            <input type="email" name="email" class="nl-email" placeholder="Your E-mail">
                            <input type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Newsletter Area End -->

    <!-- Footer Area Start -->
    @include('layouts.footer')
    <!-- Footer Area End -->

    <!-- Scripts -->
    <script src="{{ asset('js/jquery/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/active.js') }}"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.nice-select').hide();
            $('#country').select2();
        });
    </script>
    <script>
        document.getElementById('checkout-form').addEventListener('submit', function(event) {
            console.log('Form submitted');
            console.log('First Name:', document.getElementById('first_name').value);
            console.log('Last Name:', document.getElementById('last_name').value);
            console.log('Email:', document.getElementById('email').value);
            console.log('Address:', document.getElementById('street_address').value);
            console.log('City:', document.getElementById('city').value);
            console.log('Zip Code:', document.getElementById('zipCode').value);
            console.log('Phone:', document.getElementById('phone_number').value);
            var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            console.log('Payment Method:', paymentMethod);
        });
    </script>
</body>

</html>