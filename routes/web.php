<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');


// 商品登録フォーム（画面表示）
Route::get('/products/register', [ProductController::class, 'showRegister'])->name('products.register');

// 商品登録処理
Route::post('/products/register', [ProductController::class, 'register'])->name('products.register.post');

Route::get('/products/{id}', [ProductController::class, 'detail'])->name('products.detail');
Route::get('/products/{productId}/update', [ProductController::class, 'showUpdate']);
Route::post('/products/{productId}/update', [ProductController::class, 'update']);

Route::get('/products/search', [ProductController::class, 'search']);

Route::post('/products/{productId}/delete', [ProductController::class, 'delete']);
