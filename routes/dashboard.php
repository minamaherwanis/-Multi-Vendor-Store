<?php
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ImportProductsController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\RolesController;
use Faker\Guesser\Name;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\CheckUserType;
use App\Http\Controllers\Dashboard\ProfileController;

Route::group(
    [


        'middleware' => ['auth:admin,web'],
        'prefix'=>'admin'

    ],
    function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

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
        // Route::resource('dashboard/categories', CategoriesController::class);
        // Route::resource('dashboard/products', ProductsController::class);
    Route::get('products/import', [ImportProductsController::class, 'create'])
        ->name('products.import');
    Route::post('products/import', [ImportProductsController::class, 'store']); 
           Route::resources([
            'products'=>ProductsController::class,
            'categories'=>CategoriesController::class,
            'roles'=>RolesController::class,
        ]);
    }
);