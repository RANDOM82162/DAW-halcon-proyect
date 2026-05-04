<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Health check routes
Route::get('/', function () {
    return response()->json([
        'message' => 'API ROOT OK',
        'status' => 'healthy'
    ]);
});

Route::get('/test', function () {
    return response()->json([
        'message' => 'API funcionando desde Laravel'
    ]);
});

// Public authentication routes (no auth required)
Route::post('/auth/login', [AuthController::class, 'login']);

// Public search
Route::get('/public/orders/{identifier}', [OrderController::class, 'publicSearch']);

// Protected routes (auth required)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::put('/auth/profile', [AuthController::class, 'updateProfile']);
    Route::post('/auth/profile/photo', [AuthController::class, 'uploadProfilePhoto']);
    
    // Sanctum user endpoint
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Resource routes for Users
    Route::apiResource('users', UserController::class);

    // Resource routes for Products
    Route::apiResource('products', ProductController::class);

    // Resource routes for Orders
    Route::apiResource('orders', OrderController::class);
    Route::post('orders/{id}/restore', [OrderController::class, 'restore']);
    Route::delete('orders/{id}/force', [OrderController::class, 'forceDestroy']);
    Route::post('orders/{id}/upload-photo', [OrderController::class, 'uploadPhoto']);

    // Resource routes for Inventory
    Route::apiResource('inventory', InventoryController::class);
});