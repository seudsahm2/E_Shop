<!-- filepath: /C:/xampp/htdocs/E_Shop/resources/views/admin/insight.blade.php -->
@extends('layouts.admin')
<link rel="stylesheet" href="{{ asset('css/admin/insight.css') }}">
@section('content')
<div class="container">
    <section class="insight-section">
        <h2>Product Insights</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="stat-item">
                    <h3>Total Sales</h3>
                    <p class="stat-value">${{ number_format($totalSales, 2) }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <h3>Orders Today</h3>
                    <p class="stat-value">{{ $ordersToday }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <h3>Top Selling Product</h3>
                    <p class="stat-value">{{ $topSellingProduct->name }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <h3>Pending Orders</h3>
                    <p class="stat-value">{{ $pendingOrders }}</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Total Revenue</th>
                    <th>Profit</th>
                    <th>Units Sold</th>
                    <th>User ID</th>
                </tr>
            </thead>
            <tbody>
                @foreach($insights as $insight)
                <tr>
                    <td>{{ $insight->product }}</td>
                    <td>${{ number_format($insight->total_revenue, 2) }}</td>
                    <td>${{ number_format($insight->profit, 2) }}</td>
                    <td>{{ $insight->units_sold }}</td>
                    <td>{{ $insight->user_id }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>


</div>
@endsection

@section('scripts')
<script src="{{ asset('js/admin/insight.js') }}"></script>
@endsection