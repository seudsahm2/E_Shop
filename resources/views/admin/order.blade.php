<!-- filepath: /C:/xampp/htdocs/E_Shop/resources/views/admin/order.blade.php -->
@extends('layouts.admin')
<link rel="stylesheet" href="{{ asset('css/admin/order.css') }}">
@section('title', 'Order Details')

@section('content')
<div class="order-details-wrapper">
    <!-- Header Section -->
    <div class="order-header">
        <h2 class="page-title">Order Details</h2>
        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="status-form">
            @csrf
            @method('PUT')
            <label for="status">Status:</label>
            <select name="status" class="status-dropdown {{ strtolower($order->status) }}" data-order-id="{{ $order->id }}">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
            </select>
        </form>
    </div>

    <!-- Order Summary Section -->
    <div class="order-info">
        <div class="info-block">
            <h3>Order Information</h3>
            <ul>
                <li><strong>Order ID:</strong> #{{ $order->id }}</li>
                <li><strong>User:</strong> {{ $order->user->first_name }} {{ $order->user->last_name }}</li>
                <li><strong>Total:</strong> ${{ number_format($order->total, 2) }}</li>
                <li><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</li>
                <li><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</li>
            </ul>
        </div>
    </div>

    <!-- Order Items Section -->
    <div class="order-items">
        <h3 class="section-title">Order Items</h3>
        <div class="items-grid">
            @foreach($order->items as $item)
            <div class="item-card">
                <h4>{{ $item->product->name }}</h4>
                <p><strong>Quantity:</strong> {{ $item->quantity }}</p>
                <p><strong>Price:</strong> ${{ number_format($item->price, 2) }}</p>
                <p><strong>Total:</strong> ${{ number_format($item->price * $item->quantity, 2) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.status-dropdown').addEventListener('change', function() {
            var form = this.closest('form');
            var orderId = this.getAttribute('data-order-id');
            var formData = new FormData(form);

            fetch(form.action, {
                    method: form.method,
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Order status updated successfully.');

                        // Update the dropdown class based on the selected value
                        this.className = 'status-dropdown ' + this.value.toLowerCase();
                    } else {
                        alert('An error occurred: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the order status.');
                });
        });

        // Set the initial class based on the selected value
        document.querySelector('.status-dropdown').className = 'status-dropdown ' + document.querySelector('.status-dropdown').value.toLowerCase();
    });
</script>
@endsection