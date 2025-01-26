<!-- filepath: /C:/xampp/htdocs/E_Shop/resources/views/admin/order.blade.php -->
@extends('layouts.admin')
<link rel="stylesheet" href="{{ asset('css/admin/order.css') }}">
@section('title', 'Order Details')

@section('content')
<div class="order-details-wrapper">
    <!-- Header Section -->
    <div class="order-header">
        <h2 class="page-title">Order Details</h2>
        <span class="order-status {{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
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