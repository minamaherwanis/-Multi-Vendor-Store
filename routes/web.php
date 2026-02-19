<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CurrencyConverterController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OrdersController;
use App\Http\Controllers\Front\PaymentsController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\StripeWebhooksController;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Dashboard\ProfileController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;




// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::group(['prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
],
 function()
 {
Route::get(  '/',   [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductsController::class, 'index'])->name('frontend.products.index');
Route::get('/products/{product:slug}', [ProductsController::class, 'show'])->name('frontend.products.show');

Route::resource('cart',CartController::class);

Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
Route::post('checkout', [CheckoutController::class, 'store']);

Route::get('auth/user/2fa', [TwoFactorAuthenticationController::class, 'index'])->name('front.2fa');

Route::post('/currency',[CurrencyConverterController::class,'store'])->name('currency.store');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])
    ->name('auth.socilaite.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])
    ->name('auth.socilaite.callback');

Route::get('auth/{provider}/user', [\App\Http\Controllers\SocialController::class, 'index']);

Route::get('orders/{order}/pay',[PaymentsController::class,'create'])
->name('orders.payments.create');
Route::post('orders/{order}/stripe/payment-intent', [PaymentsController::class, 'createStripePaymentIntent'])
    ->name('stripe.paymentIntent.create');
Route::get('orders/{order}/pay/stripe/callback', [PaymentsController::class, 'confirm'])
    ->name('stripe.return');
    
Route::any('stripe/webhook', [StripeWebhooksController::class, 'handle']);
Route::get('/orders/{order}',[OrdersController::class,'show'])->name('orders.show');

// require __DIR__ . '/auth.php';

require __DIR__ . '/dashboard.php';
