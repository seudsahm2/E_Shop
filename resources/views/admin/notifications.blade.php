@extends('layouts.admin')
<link rel="stylesheet" href="{{ asset('css/admin/notifications.css') }}">

@section('title', 'Admin - Notifications')

@section('content')
<div class="container">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <header class="page-header">
        <h2>Notifications</h2>
    </header>

    <!-- Notification List Section -->
    <section class="notifications-list" id="notifications-list">
        <!-- Notifications will be appended here by JavaScript -->
    </section>
    <p id="no-notifications-message" style="display: none;">No notifications found.</p>
</div>
@endsection

@section('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('{{ env('
        PUSHER_APP_KEY ') }}', {
            cluster: '{{ env('
            PUSHER_APP_CLUSTER ') }}',
            forceTLS: true
        });

    pusher.connection.bind('error', function(err) {
        console.error('Pusher connection error:', err);
    });

    var channel = pusher.subscribe('orders');
    channel.bind('pusher:subscription_succeeded', function() {
        console.log('Successfully subscribed to the orders channel');
    });

    channel.bind('pusher:subscription_error', function(status) {
        console.error('Subscription error:', status);
    });

    channel.bind('order.placed', function(data) {
        console.log('OrderPlaced event received:', data);
        addNotification(data.order.id, data.order.total);
    });

    function addNotification(notificationId, orderId, total, userName) {
        var notificationList = document.getElementById('notifications-list');
        var notificationCard = document.createElement('div');
        notificationCard.className = 'notification-card';
        notificationCard.innerHTML = `
            <a href="/admin/orders/${orderId}" class="notification-link">
                <div class="notification-header">
                    <span class="notification-title">New Order Placed</span>
                    <span class="notification-time">${new Date().toLocaleTimeString()}</span>
                </div>
                <div class="notification-body">
                    Order ID: ${orderId}<br>
                    Total: $${total}<br>
                    User: ${userName}
                </div>
            </a>
            <button class="mark-as-read" data-id="${notificationId}">Mark as Read</button>
        `;
        notificationList.prepend(notificationCard);
    }

    var productChannel = pusher.subscribe('products');

    productChannel.bind('product.low_stock', function(data) {
        console.log('LowStockNotification event received:', data);
        addLowStockNotification(data.product.id, data.product.name, data.product.quantity);
    });

    function addLowStockNotification(productId, productName, quantity) {
        var notificationList = document.getElementById('notifications-list');
        var notificationCard = document.createElement('div');
        notificationCard.className = 'notification-card';
        notificationCard.innerHTML = `
        <a href="/admin/products/${productId}/edit" class="notification-link">
            <div class="notification-header">
                <span class="notification-title">Low Stock Alert</span>
                <span class="notification-time">${new Date().toLocaleTimeString()}</span>
            </div>
            <div class="notification-body">
                Product: ${productName}<br>
                Remaining Quantity: ${quantity}
            </div>
        </a>
        <button class="mark-as-read" data-id="${productId}">Mark as Read</button>
    `;
        notificationList.prepend(notificationCard);
    }


    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('mark-as-read')) {
            var notificationId = event.target.getAttribute('data-id');
            console.log("notification id", notificationId);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', `http://eshop.local/admin/notifications/${notificationId}/read`, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        event.target.parentElement.remove();
                    }
                } else if (xhr.readyState === 4) {
                    console.error('Error marking notification as read:', xhr.responseText);
                }
            };

            xhr.send();
        }
    });

    fetch('/admin/notifications/fetch')
        .then(response => response.json())
        .then(notifications => {
            if (notifications.length === 0) {
                document.getElementById('no-notifications-message').style.display = 'block';
            } else {
                document.getElementById('no-notifications-message').style.display = 'none';
                notifications.forEach(notification => {
                    // Dynamically determine the method to call based on the notification data structure
                    if (notification.order) {
                        const fullName = notification.order.user.first_name + " " + notification.order.user.last_name;
                        addNotification(notification.id, notification.order.id, notification.order.total, fullName);
                    }

                    if (notification.product) {
                        addLowStockNotification(notification.product.id, notification.product.name, notification.product.quantity);
                    }

                    // If there are additional types of notifications, handle them here as well
                });
            }
        })
        .catch(error => {
            console.error('Error fetching notifications:', error);
        });



    function checkNotifications() {
        var notificationList = document.getElementById('notifications-list');
        if (notificationList.children.length === 0) {
            document.getElementById('no-notifications-message').style.display = 'block';
        } else {
            document.getElementById('no-notifications-message').style.display = 'none';
        }
    }
</script>
@endsection