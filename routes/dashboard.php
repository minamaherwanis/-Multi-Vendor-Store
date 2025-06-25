<?php
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\ProfileController;
use Faker\Guesser\Name;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::group(
    [


        'middleware' => ['auth']

    ],
    function () {
        Route::get('profile', action: [\App\Http\Controllers\Dashboard\ProfileController::class ,'edit'] )->name('profile.edit');
        Route::patch('profile', action: [\App\Http\Controllers\Dashboard\ProfileController::class ,'update'] )->name('profile.update');

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index'],
        )->name('dashboard');


        // راوت للعرض العناصر المحذوفة (soft delete)
        Route::get('dashboard/categories/trash', [CategoriesController::class, 'trash'])
            ->name('categories.trash');

        // راوت لاسترجاع عنصر محذوف
        Route::put('dashboard/categories/{category}/restore', [CategoriesController::class, 'restore'])
            ->name('categories.restore');

        // راوت لحذف عنصر نهائيًا (force delete)
        Route::delete('dashboard/categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])
            ->name('categories.force-delete');

        Route::resource('dashboard/categories', CategoriesController::class);
        Route::resource('dashboard/products', ProductsController::class);
    }
);