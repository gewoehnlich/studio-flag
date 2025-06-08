<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Middleware\EnsureAcceptApplicationJsonHeader;

require __DIR__ . '/auth.php';

Route::middleware('auth:sanctum', EnsureAcceptApplicationJsonHeader::class)->group(function () {
    Route::resources([
        'products' => ProductController::class,
        'cart' => CartController::class,
        'cart/items' => CartItemController::class
    ]);
});
