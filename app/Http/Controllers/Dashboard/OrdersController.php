<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
public function index()
{
        if (!auth()->user()->store_id) {
        return redirect()->route('dashboard')
            ->with('info', 'Your account is not activated yet. Please contact the administrator to activate your account.');
    }
    $storeId = Auth::user()->store_id;

    $orders = Order::where('store_id', $storeId)
             ->orderBy('created_at', 'desc') 
        ->paginate(9);

    return view('dashboard.orders.index', compact('orders'));
}
public function show(Order $order)
{
        if (!auth()->user()->store_id) {
        return redirect()->route('dashboard')
            ->with('info', 'Your account is not activated yet. Please contact the administrator to activate your account.');
    }
    if ($order->store_id !== Auth::user()->store_id) {
        abort(403, 'Unauthorized');
    }

    $order->load(['items.product', 'shippingAddress', 'billingAddress', 'user']);
    return view('dashboard.orders.show', compact('order'));
}



}
