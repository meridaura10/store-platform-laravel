<?php

use App\Http\Controllers\Client\PaymentController;
use Illuminate\Support\Facades\Route;

Route::controller(PaymentController::class)->group(function () {
    Route::any('/response/{payment}', 'response')->name('response');
    Route::post('/callback/{payment}', 'callback')->name('callback');
});
