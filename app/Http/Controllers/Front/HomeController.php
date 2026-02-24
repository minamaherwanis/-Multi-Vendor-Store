<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index(){
      $products=Product::with('category')->active()->latest()->paginate(32);
    return view('front.home',compact('products'));
   }
}
