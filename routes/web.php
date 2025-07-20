<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticProductController;
use App\Http\Controllers\CartController;

Route::get('/', [StaticProductController::class, 'index'])->name('home');
Route::get('/products/{id}', [StaticProductController::class, 'show'])->name('products.show');

Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::get('cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove'); 