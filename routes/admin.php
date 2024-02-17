<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Moderation\ModerationProductController;
use App\Http\Controllers\Admin\Moderation\ModerationStoreController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class)->name('home');

Route::prefix('/products')->name('product.')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{product}/moderation', 'moderation')->name('moderation');
    Route::get('/{product}', 'show')->name('show');
});

Route::prefix('/orders')->name('order.')->controller(OrderController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/moderation/{order}', 'moderation')->name('moderation');
    Route::get('/edit/{order}', 'edit')->name('edit');
});

Route::prefix('/moderation')->name('moderation.')->group(function () {
    Route::prefix('/products')->name('product.')->controller(ModerationProductController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::prefix('/products')->name('product.')->controller(ModerationProductController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::prefix('/stores')->name('stor.')->controller(ModerationStoreController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});