<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index(Request $request)
   {
      $filters = $request->only(['name']);

      $products = Product::with('category')
         ->withoutGlobalScope('store')
         ->frontendFilter($filters) 
         ->latest()
         ->paginate(32);

      return view('front.home', compact('products'));
   }
}

