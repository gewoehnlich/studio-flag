<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Middleware\EnsureAcceptApplicationJsonHeader;

require __DIR__ . '/auth.php';

Route::middleware('auth:sanctum', EnsureAcceptApplicationJsonHeader::class)->group(function () {
    // Route::resources([
    //     'products' => ProductController::class,
    //     'cart' => CartController::class,
    //     'cart/items' => CartItemController::class,
    //     'order' => OrderController::class,
    //     'order/items' => OrderItemController::class,
    //     'payment_methods' => PaymentMethodController::class
    // ]);

    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    Route::get('/carts', [CartController::class, 'index']);
    Route::post('/carts', [CartController::class, 'store']);
    Route::put('/carts/{id}', [CartController::class, 'update']);
    Route::delete('/carts/{id}', [CartController::class, 'destroy']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::put('/orders/{id}', [OrderController::class, 'update']);
    Route::delete('/orders/{id}', [OrderController::class, 'destroy']);

    Route::get('/payment_methods', [PaymentMethodController::class, 'index']);
    Route::post('/payment_methods', [PaymentMethodController::class, 'store']);
    Route::put('/payment_methods/{id}', [PaymentMethodController::class, 'update']);
    Route::delete('/payment_methods/{id}', [PaymentMethodController::class, 'destroy']);
});
