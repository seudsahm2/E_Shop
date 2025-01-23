<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                            <button type="submit"><img src="img/core-img/search.png" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Wrapper Area End -->

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        <!-- Mobile Nav (max width 767px)-->

        @include('layouts.mobile_header')

        <!-- Header Area Start -->

        @include('layouts.header')

        <!-- Header Area End -->


        <div class="cart-table-area section-padding-100">
            <div class="container-fluid">
                @if($cart->items->isEmpty())
                <div class="alert alert-info">
                    No items available in the cart.
                </div>
                @else
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="cart-title mt-50">
                            <h2>Shopping Cart</h2>
                        </div>

                        <div class="cart-table clearfix">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart->items as $item)
                                    <tr>
                                        <td class="cart_product_img">
                                            <a href="#"><img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}"></a>
                                        </td>
                                        <td class="cart_product_desc">
                                            <h5>{{ $item->product->name }}</h5>
                                        </td>
                                        <td class="price">
                                            <span>${{ number_format($item->product->price, 2) }}</span>
                                        </td>
                                        <td class="qty">
                                            <div class="qty-btn d-flex">
                                                <p>Qty</p>
                                                <div class="quantity">
                                                    <input type="number" name="quantity" class="qty-text qty-input" step="1"
                                                        min="1" max="{{ $item->product->quantity }}"
                                                        value="{{ $item->quantity }}"
                                                        data-id="{{ $item->product->id }}">
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-primary update-btn"
                                                data-id="{{ $item->product->id }}">Update</button>
                                        </td>


                                        <td>
                                            <form action="{{ route('cart.remove', ['id' => $item->product->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>


                            </table>
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
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning mt-2">Clear Cart</button>
                            </form>
                            <div class="cart-btn mt-100">
                                <a href="{{ route('checkout') }}" class="btn amado-btn w-100">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>



    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Newsletter Area Start ##### -->
    <section class="newsletter-area section-padding-100-0">
        <div class="container">
            <div class="row align-items-center">
                <!-- Newsletter Text -->
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="newsletter-text mb-100">
                        <h2>Subscribe for a <span>25% Discount</span></h2>
                        <p>Nulla ac convallis lorem, eget euismod nisl. Donec in libero sit amet mi vulputate consectetur. Donec auctor interdum purus, ac finibus massa bibendum nec.</p>
                    </div>
                </div>
                <!-- Newsletter Form -->
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
    <!-- ##### Newsletter Area End ##### -->

    <!-- ##### Footer Area Start ##### -->

    @include('layouts.footer')

    <!-- ##### Footer Area End ##### -->

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
            const updateButtons = document.querySelectorAll('.update-btn');

            updateButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = button.dataset.id;
                    const quantityInput = document.querySelector(`.qty-input[data-id="${productId}"]`);
                    const quantity = quantityInput.value;

                    if (quantity <= 0) {
                        alert('Quantity must be at least 1.');
                        return;
                    }

                    fetch(`/cart/update/${productId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({
                                quantity
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update Subtotal
                                document.querySelector('#cart-subtotal').textContent = `$${data.subtotal.toFixed(2)}`;

                                // Update Delivery Fee
                                document.querySelector('#cart-delivery').textContent = `$${data.deliveryFee.toFixed(2)}`;

                                // Update Total
                                document.querySelector('#cart-total').textContent = `$${data.newTotal.toFixed(2)}`;

                                alert('Cart updated successfully.');
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>

</body>

</html>