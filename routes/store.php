<?php

use App\Http\Controllers\Store\OrderController;
use App\Http\Controllers\Store\HomeController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\RoleController;
use App\Http\Controllers\Store\StoreUserController;
use App\Http\Controllers\Store\StoreController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class)->name('home');


Route::prefix('/products')->name('product.')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/edit/{product}', 'form')->name('edit');
    Route::get('/create', 'form')->name('create');
});

Route::prefix('/orders')->name('order.')->controller(OrderController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/moderation/{order}', 'moderation')->name('moderation');
    Route::get('/edit/{order}', 'edit')->name('edit');
});

Route::prefix('/staff')->name('staff.')->controller(StoreUserController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/{storeUser}/edit', 'edit')->name('edit');
});

Route::prefix('/roles')->name('role.')->controller(RoleController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/{role}/edit', 'edit')->name('edit');
});

Route::prefix('/store')->name('store.')->controller(StoreController::class)->group(function () {
    Route::get('/', 'show')->name('show');
    Route::get('/edit', 'edit')->name('edit');
});

Route::prefix('/analitic')->name('analitic.')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/edit/{product}', 'form')->name('edit');
    Route::get('/create', 'form')->name('create');
});
