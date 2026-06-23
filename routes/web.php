<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/register', [ProductController::class, 'showRegister'])
    ->name('products.register');


// 商品登録
Route::get('/products/register', [ProductController::class, 'showRegister'])->name('products.register');
Route::post('/products/register', [ProductController::class, 'register'])->name('products.register.post');

// 商品検索（静的）
Route::get('/products/search', [ProductController::class, 'search']);

// 商品詳細（動的）
Route::get('/products/{id}', [ProductController::class, 'detail'])->name('products.detail');

// 商品更新（動的）
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

// 商品削除（動的）
Route::delete('/products/{productId}/delete', [ProductController::class, 'delete'])->name('products.destroy');
