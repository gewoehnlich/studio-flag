<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\EnsureAcceptApplicationJsonHeader;

require __DIR__ . '/auth.php';

Route::middleware('auth:sanctum', EnsureAcceptApplicationJsonHeader::class)->group(function () {
    Route::resources([
        'products' => ProductController::class
    ]);
});
