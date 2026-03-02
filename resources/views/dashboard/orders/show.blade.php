@extends('layouts.dashboard')
{{-- @extends('layouts.partials.nav') --}}





@section('content')
<div class="container">
    <h2 class="mb-4">تفاصيل الطلب رقم #{{ $order->id }}</h2>

    <div class="row">
        <!-- Billing Address -->
        <div class="col-md-6">
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white">بيانات الفواتير (Billing Address)</div>
                <div class="card-body">
                    @php $billing = $order->addresses->where('type','billing')->first(); @endphp
                    @if($billing)
                        <p><strong>الاسم:</strong> {{ $billing->first_name }} {{ $billing->last_name }}</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $billing->email }}</p>
                        <p><strong>الهاتف:</strong> {{ $billing->phone_number }}</p>
                        <p><strong>العنوان:</strong> {{ $billing->street_address }}, {{ $billing->city }}, {{ $billing->state }}, {{ $billing->country }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="col-md-6">
            <div class="card border-success mb-3">
                <div class="card-header bg-success text-white">بيانات الشحن (Shipping Address)</div>
                <div class="card-body">
                    @php $shipping = $order->addresses->where('type','shipping')->first(); @endphp
                    @if($shipping)
                        <p><strong>الاسم:</strong> {{ $shipping->first_name }} {{ $shipping->last_name }}</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $shipping->email }}</p>
                        <p><strong>الهاتف:</strong> {{ $shipping->phone_number }}</p>
                        <p><strong>العنوان:</strong> {{ $shipping->street_address }}, {{ $shipping->city }}, {{ $shipping->state }}, {{ $shipping->country }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




    {{-- <div class="mt-3">
        {{ $order->links() }}
    </div> --}}



