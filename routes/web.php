<?php

use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\BasketController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\StoreController;
use App\Http\Controllers\Client\UserCabinetController;
use App\Http\Controllers\Client\UserCabinetOrderController;
use App\Http\Controllers\Client\UserCabinetStoreController;
use App\Http\Controllers\Client\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', HomeController::class)->name('client.index');

Route::prefix('/user')->name('user.')->middleware('auth')->controller(UserController::class)->group(function () {

    Route::prefix('/cabinet')->name('cabinet.')->controller(UserCabinetController::class)->group(function () {
        Route::get('/', 'index')->name('index');

        Route::prefix('/orders')->name('order.')->controller(UserCabinetOrderController::class)->group(function () {
            Route::get('/', 'index')->name('index');
        });

        Route::prefix('/stores')->name('store.')->controller(UserCabinetStoreController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/cteate', 'create')->name('create');
        });
    });

    Route::get('/user', 'user')->name('user');
});

Route::prefix('/products')->name('product.')->controller(ProductController::class)->group(function () {
    Route::get('/{product}', 'show')->name('show');
});

Route::prefix('/categories')->name('category.')->controller(CategoryController::class)->group(function () {
    Route::get('/{category}', 'show')->name('show');
});

Route::prefix('/stores')->name('store.')->controller(StoreController::class)->group(function () {
    Route::get('/{store}', 'show')->name('show');   
    Route::get('/{store}/products', 'products')->name('product.index');
});


Route::prefix('order')->name('order.')->controller(OrderController::class)->group(function () {
    Route::get('/checkout', 'checkout')->middleware(['auth'])->name('checkout');
});

Route::get('/basket', BasketController::class)->name('basket.index');
