<!-- filepath: /C:/xampp/htdocs/E_Shop/resources/views/admin/orders.blade.php -->
@extends('layouts.admin')
<link rel="stylesheet" href="{{ asset('css/admin/order_style.css') }}">
@section('title', 'Admin - Orders')

@section('content')
<div class="container">
    <header class="page-header">
        <h2>Order Management</h2>
    </header>

    <!-- Orders Table Section -->
    <section class="orders-table-section">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                    <td>
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="status-form">
                            @csrf
                            @method('PUT')
                            <select name="status" class="status-dropdown {{ strtolower($order->status) }}" data-order-id="{{ $order->id }}">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <button class="btn view-btn" onclick="viewOrder({{ $order->id }})">
                            View
                        </button>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <!-- Order Summary -->
    <section class="order-summary">
        <div class="summary-card">
            <div class="icon-container">
                <i class="fas fa-box"></i>
            </div>
            <h3>Total Orders</h3>
            <span id="total-orders">{{ $orders->count() }}</span>
        </div>
        <div class="summary-card">
            <div class="icon-container">
                <i class="fas fa-truck"></i>
            </div>
            <h3>Shipped</h3>
            <span id="shipped-orders">{{ $orders->where('status', 'shipped')->count() }}</span>
        </div>
        <div class="summary-card">
            <div class="icon-container">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3>Delivered</h3>
            <span id="delivered-orders">{{ $orders->where('status', 'delivered')->count() }}</span>
        </div>
        <div class="summary-card">
            <div class="icon-container">
                <i class="fas fa-times-circle"></i>
            </div>
            <h3>Canceled</h3>
            <span id="canceled-orders">{{ $orders->where('status', 'canceled')->count() }}</span>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.status-dropdown').forEach(function(dropdown) {
            dropdown.addEventListener('change', function() {
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
                            document.getElementById('total-orders').textContent = data.totalOrders;
                            document.getElementById('shipped-orders').textContent = data.shippedOrders;
                            document.getElementById('delivered-orders').textContent = data.deliveredOrders;
                            document.getElementById('canceled-orders').textContent = data.canceledOrders;

                            // Update the dropdown class based on the selected value
                            dropdown.className = 'status-dropdown ' + dropdown.value.toLowerCase();
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
            dropdown.className = 'status-dropdown ' + dropdown.value.toLowerCase();
        });
    });

    function viewOrder(orderId) {
        // Implement the view order functionality here
        alert('Viewing order ' + orderId);
    }
</script>
@endsection