@extends('layouts.admin')
@section('title', 'Admin - Manage Orders')
<link rel="stylesheet" href="{{ asset('css/admin/order_style.css') }}">
@section('content')
<div class="container">
    <header class="page-header">
        <h2>Order Management</h2>
    </header>

    <!-- Filter Button -->
    <button id="toggle-filter" class="btn btn-secondary mb-3">Filter</button>

    <!-- Filter Form -->
    <div class="filter-form" style="display: none;">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="form-inline">
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" class="form-control">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                </select>
            </div>
            <div class="form-group">
                <label for="min_price">Min Price:</label>
                <input type="number" name="min_price" id="min_price" class="form-control" value="{{ request('min_price') }}">
            </div>
            <div class="form-group">
                <label for="max_price">Max Price:</label>
                <input type="number" name="max_price" id="max_price" class="form-control" value="{{ request('max_price') }}">
            </div>
            <div class="form-group">
                <label for="min_quantity">Min Quantity:</label>
                <input type="number" name="min_quantity" id="min_quantity" class="form-control" value="{{ request('min_quantity') }}">
            </div>
            <div class="form-group">
                <label for="max_quantity">Max Quantity:</label>
                <input type="number" name="max_quantity" id="max_quantity" class="form-control" value="{{ request('max_quantity') }}">
            </div>
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>



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
                <tr id="order-{{ $order->id }}">
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
                        <a href="{{ url('admin/orders/' . $order->id) }}" class="btn btn-success">View</a>

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
                            document.getElementById(`order-${orderId}`).remove();

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
</script>
<script>
    document.getElementById('toggle-filter').addEventListener('click', function() {
        var filterForm = document.querySelector('.filter-form');
        if (filterForm.style.display === 'none') {
            filterForm.style.display = 'block';
        } else {
            filterForm.style.display = 'none';
        }
    });
</script>
@endsection