<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);
Route::post('logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');
