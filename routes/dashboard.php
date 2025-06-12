<?php
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\ProfileController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::group(
    [

        
        'middleware'=>['auth']

    ],
    function () {

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index'],
        )->name('dashboard');

        Route::resource('dashboard/categories', CategoriesController::class) ;
    }
);