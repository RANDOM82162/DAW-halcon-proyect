<?php

use Illuminate\Support\Facades\Route;

// 1. Ruta Raíz: Vista principal pública
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

// 2. Rutas del andamiaje de Autenticación (Login, Registro, Recuperación)
Auth::routes();

// 3. Ruta de inicio post-autenticación
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 4. Resource Routes for Users
Route::resource('users', App\Http\Controllers\UserController::class)->middleware('auth');

// 5. Resource Routes for Orders
Route::get('orders/archived', [App\Http\Controllers\OrderController::class, 'archived'])->name('orders.archived')->middleware('auth');
Route::patch('orders/{order}/restore', [App\Http\Controllers\OrderController::class, 'restore'])->name('orders.restore')->middleware('auth');
Route::get('orders/{order}/photo', [App\Http\Controllers\OrderController::class, 'photoForm'])->name('orders.photo')->middleware('auth');
Route::post('orders/{order}/photo', [App\Http\Controllers\OrderController::class, 'storePhoto'])->name('orders.storePhoto')->middleware('auth');
Route::resource('orders', App\Http\Controllers\OrderController::class)->middleware('auth');
