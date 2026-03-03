<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('order', [OrderController::class, 'index']);
Route::get('order-stripe', [OrderController::class, 'stripe'])->name('order-stripe');

Route::post('stripe-pay', [StripeController::class, 'store'])->name('stripe-pay');
