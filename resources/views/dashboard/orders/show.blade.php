@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Order #{{ $order->number }}</h1>

    <!-- Customer Info -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            Customer Information
        </div>
        <div class="card-body">
            <p><strong>Customer:</strong> {{ $order->user->name ?? '---' }}</p>
            <p><strong>Status:</strong> 
                <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
            </p>
            <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
            <p><strong>Total:</strong> 
                <span class="badge bg-success">${{ number_format($order->total, 2) }}</span>
            </p>
        </div>
    </div>

    <!-- Shipping & Billing Cards -->
    <div class="row">
        <!-- Shipping Info -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-info text-white">
                    Shipping Information
                </div>
                <div class="card-body">
                    @if($order->shippingAddress)
                        <p><strong>Name:</strong> {{ $order->shippingAddress->first_name }} {{ $order->shippingAddress->last_name }}</p>
                        <p><strong>Email:</strong> {{ $order->shippingAddress->email }}</p>
                        <p><strong>Phone:</strong> {{ $order->shippingAddress->phone_number }}</p>
                        <p><strong>Address:</strong> {{ $order->shippingAddress->street_address }}</p>
                        <p><strong>City:</strong> {{ $order->shippingAddress->city }}</p>
                        <p><strong>State:</strong> {{ $order->shippingAddress->state }}</p>
                        <p><strong>Country:</strong> {{ $order->shippingAddress->country }}</p>
                    @else
                        <p class="text-muted">لا يوجد بيانات شحن</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Billing Info -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    Billing Information
                </div>
                <div class="card-body">
                    @if($order->billingAddress)
                        <p><strong>Name:</strong> {{ $order->billingAddress->first_name }} {{ $order->billingAddress->last_name }}</p>
                        <p><strong>Email:</strong> {{ $order->billingAddress->email }}</p>
                        <p><strong>Phone:</strong> {{ $order->billingAddress->phone_number }}</p>
                        <p><strong>Address:</strong> {{ $order->billingAddress->street_address }}</p>
                        <p><strong>City:</strong> {{ $order->billingAddress->city }}</p>
                        <p><strong>State:</strong> {{ $order->billingAddress->state }}</p>
                        <p><strong>Country:</strong> {{ $order->billingAddress->country }}</p>
                    @else
                        <p class="text-muted">لا يوجد بيانات فاتورة</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Product Info -->
<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        Product
    </div>
    <div class="card-body">
        @php
            $item = $order->items->first();
        @endphp

        @if($item)
            <div class="d-flex align-items-center gap-4">
                <img src="{{ asset('storage/' . $item->product->image) }}" 
                     alt="{{ $item->product->name ?? $item->product_name }}" 
                     class="img-thumbnail" style="width:120px;height:120px; margin-right:20px;">
                
                <div>
                    <p><strong>Name:</strong> {{ $item->product->name ?? $item->product_name }}</p>
                    <p><strong>Price:</strong> ${{ number_format($item->price, 2) }}</p>
                    <p><strong>Quantity Ordered:</strong> {{ $item->quantity }}</p>
                    
                    <p><strong>Stock Remaining:</strong>
                        @if($item->product->quantity > 0)
                            <span class="badge bg-info">{{ $item->product->quantity }}</span>
                        @else
                            <span class="badge bg-danger">Out of Stock</span>
                            <small class="text-muted d-block">
                               This order consumes the last piece of stock.
                            </small>
                        @endif
                    </p>
                </div>
            </div>
        @else
            <p class="text-muted">There is no product associated with this order.    </p>
        @endif
    </div>
</div>
</div>
@endsection