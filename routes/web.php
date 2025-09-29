<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Dashboard\ProfileController;



// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get(  '/',   [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductsController::class, 'index'])->name('frontend.products.index');
Route::get('/products/{product:slug}', [ProductsController::class, 'show'])->name('frontend.products.show');

Route::resource('cart',CartController::class);

Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
Route::post('checkout', [CheckoutController::class, 'store']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__ . '/auth.php';

require __DIR__ . '/dashboard.php';


