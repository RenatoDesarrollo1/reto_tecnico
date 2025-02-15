<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['throttle:api'])->group(function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);



    Route::middleware(['auth:api'])->group(function () {

        Route::post("/register", [AuthController::class, 'register'])->middleware(['role:admin']);

        Route::get('/product', [ProductController::class, 'index'])->middleware(['role:admin|seller']);
        Route::get("/product/{id}", [ProductController::class, 'get'])->middleware(['role:admin|seller']);
        Route::post("/product", [ProductController::class, 'store'])->middleware(['role:admin|seller']);
        Route::patch("/product/{id}", [ProductController::class, 'update'])->middleware(['role:admin|seller']);
        Route::delete("/product/{id}", [ProductController::class, 'destroy'])->middleware(['role:admin']);

        Route::get('/sale', [ProductController::class, 'index'])->middleware(['role:admin']);
        Route::post("/sale", [ProductController::class, 'store'])->middleware(['role:admin|seller']);
    });
});
