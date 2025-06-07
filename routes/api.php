<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

require __DIR__ . '/auth.php';

Route::middleware('auth:sanctum')->group(function () {
    Route::resources([
        'products' => ProductController::class
    ]);
});
