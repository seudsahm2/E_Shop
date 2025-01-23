@extends('layouts.admin')

@section('content')
<h1 class="mb-4 dashboard-header">Admin Dashboard</h1>

<!-- Summary Section -->
<div class="summary-section">
    <div class="summary-card">
        <div class="icon-container">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <h3>Total Sales</h3>
        <span>${{ $totalSales }}</span>
    </div>
    <div class="summary-card">
        <div class="icon-container">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <h3>Total Orders</h3>
        <span>{{ $totalOrders }}</span>
    </div>
    <div class="summary-card">
        <div class="icon-container">
            <i class="fas fa-users"></i>
        </div>
        <h3>Total Users</h3>
        <span>{{ $totalUsers }}</span>
    </div>
    <div class="summary-card">
        <div class="icon-container">
            <i class="fas fa-box"></i>
        </div>
        <h3>Total Products</h3>
        <span>{{ $totalProducts }}</span>
    </div>
</div>

<!-- Charts Section -->
<div class="row mt-5">
    <div class="col-md-6">
        <div class="chart-container">
            <h5 class="chart-title">Sales Trends</h5>
            <canvas id="salesChart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="chart-container">
            <h5 class="chart-title">Orders Trends</h5>
            <canvas id="ordersChart"></canvas>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="chart-container">
            <h5 class="chart-title">Revenue Distribution</h5>
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div class="chart-container">
            <h5 class="chart-title">User Growth</h5>
            <canvas id="growthChart"></canvas>
        </div>
    </div>
</div>



@endsection

@section('scripts')

<script id="chart-data" type="application/json">
    {
        "salesChartData": @json($salesChartData),
        "ordersChartData": @json($ordersChartData),
        "pieChartData": @json($pieChartData),
        "growthChartData": @json($growthChartData)
    }
</script>

@endsection