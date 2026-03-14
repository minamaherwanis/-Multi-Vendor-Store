<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
public function index()
{
    $orders = Order::where('user_id', Auth::id())->get();

    return view('front.orders.index', ['orders' => $orders]);
}

public function show($id)
{
    $order = Order::where('id', $id)
        ->where('user_id', Auth::id())
        ->with('delivery') 
        ->firstOrFail();

    return view('front.orders.show', ['order' => $order]);
}
}
