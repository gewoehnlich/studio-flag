<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Middleware\EnsureAcceptApplicationJsonHeader;

require __DIR__ . '/auth.php';

Route::middleware('auth:sanctum', EnsureAcceptApplicationJsonHeader::class)->group(function () {

    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    Route::get('/carts', [CartController::class, 'index']);
    Route::post('/carts', [CartController::class, 'store']);
    Route::put('/carts', [CartController::class, 'update']);
    Route::delete('/carts', [CartController::class, 'destroy']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::put('/orders/{id}', [OrderController::class, 'update']);
    Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

    Route::get('/payments/link', [PaymentController::class, 'link'])->name('payment.link');
    Route::get('/payments/confirmation', [PaymentController::class, 'confirmation'])->name('payment.confirmation');

    Route::get('/payments/methods', [PaymentMethodController::class, 'index']);
    Route::post('/payments/methods', [PaymentMethodController::class, 'store']);
    Route::put('/payments/methods/{id}', [PaymentMethodController::class, 'update']);
    Route::delete('/payments/methods/{id}', [PaymentMethodController::class, 'destroy']);
});
