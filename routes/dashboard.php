<?php
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ImportProductsController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\OrdersController;
use App\Http\Controllers\Dashboard\RolesController;
use Faker\Guesser\Name;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\CheckUserType;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\MakeAdminController;
use App\Http\Controllers\AdminAuthController;
Route::group(
    [


        'middleware' => ['auth', 'checkUserType:admin'],
        'prefix'=>'admin'

    ],
    
    function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('admin.profile.update');

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

    Route::get('products/import', [ImportProductsController::class, 'create'])
        ->name('products.import');
    Route::post('products/import', [ImportProductsController::class, 'store']); 
           Route::resources([
            'products'=>ProductsController::class,
            'categories'=>CategoriesController::class,
            // 'roles'=>RolesController::class,
        ]);
Route::get('/orders', [OrdersController::class, 'index'])
->name('admin.orders.index');
Route::get('/orders/{order}', [OrdersController::class, 'show'])
->name('admin.orders.show');
    }
);



Route::get('/super-admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/super-admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/super-admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


Route::middleware(['auth:admin', 'super_admin'])->group(function () {
    Route::get('/super-admin', [MakeAdminController::class, 'index'])
        ->name('adminstore.index');

    Route::get('/super-admin/store/{store}/edit', [MakeAdminController::class, 'editStore'])
        ->name('adminstore.store.edit');

    Route::put('/super-admin/store/{store}', [MakeAdminController::class, 'updateStore'])
        ->name('adminstore.store.update');

    Route::get('/super-admin/{admin}', [MakeAdminController::class, 'create'])
        ->name('adminstore.create');

    Route::post('/super-admin/{admin}', [MakeAdminController::class, 'store'])
        ->name('adminstore.store');
});




    