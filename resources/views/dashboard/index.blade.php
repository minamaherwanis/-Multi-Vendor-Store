@extends('layouts.dashboard')

@section('title')
    <h1>Dashboard</h1>
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

@if (!auth()->user()->store_id)
    {{-- No Store Assigned --}}
    <div class="row justify-content-center mt-5">
        <div class="col-lg-6 text-center">
            <div class="card shadow-sm border-0">
                <div class="card-body py-5 px-4">
                    <div class="mb-4">
                        <i class="fas fa-store-slash fa-4x text-muted"></i>
                    </div>
                    <h3 class="fw-bold text-dark">Account Not Activated</h3>
                    <p class="text-muted mt-3">
                        Your account has been created successfully, but it has not been linked to a store yet.
                        Please contact the system administrator to activate your account and assign you to a store.
                    </p>
                    <hr>
                    <p class="text-muted mb-1"><i class="fas fa-envelope me-2"></i> support@multistore.com</p>
                    <p class="text-muted"><i class="fas fa-clock me-2"></i> We typically respond within 24 hours.</p>
                    <a href="mailto:support@multistore.com" class="btn btn-dark mt-3 px-4">
                        <i class="fas fa-paper-plane me-2"></i> Contact Administrator
                    </a>
                </div>
            </div>
        </div>
    </div>

@else
    {{-- Has Store --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div>
                            <h4 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }}! 👋</h4>
                            <p class="mb-0 opacity-75">Here's what's happening with your store today.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 me-3" style="background-color: #e8f4fd;">
                            <i class="fas fa-box fa-lg" style="color: #3498db;"></i>
                        </div>
                        <h5 class="card-title mb-0 fw-bold">Products</h5>
                    </div>
                    <p class="card-text text-muted">Manage your store products, update stock and pricing.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                        View Products <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 me-3" style="background-color: #e8fdf0;">
                            <i class="fas fa-tags fa-lg" style="color: #2ecc71;"></i>
                        </div>
                        <h5 class="card-title mb-0 fw-bold">Categories</h5>
                    </div>
                    <p class="card-text text-muted">Organize your products into categories for easier browsing.</p>
                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-success mt-2">
                        View Categories <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 me-3" style="background-color: #fdf6e8;">
                            <i class="fas fa-shopping-cart fa-lg" style="color: #f39c12;"></i>
                        </div>
                        <h5 class="card-title mb-0 fw-bold">Orders</h5>
                    </div>
                    <p class="card-text text-muted">Track and manage customer orders placed in your store.</p>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-warning mt-2">
                        View Orders <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection