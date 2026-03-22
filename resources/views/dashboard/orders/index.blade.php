@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Orders</h1>

    <div class="row">
        @forelse($orders as $order)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Order #{{ $order->number }}
                    </div>
                    <div class="card-body">
                        <p><strong>Customer:</strong> {{ $order->user->name ?? '---' }}</p>
                        <p><strong>Total:</strong> 
                            <span class="badge bg-success">${{ number_format($order->total, 2) }}</span>
                        </p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                        </p>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-light bg-primary">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    لا توجد طلبات حتى الآن
                </div>
            </div>
        @endforelse
        <div class="d-flex justify-content-center mt-4">
 
</div>


    </div>   {{ $orders->links() }}
</div>
@endsection