<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
// Route cho Admin
Route::prefix('admin')->group(function () {
    Route::get('', [CategoryController::class, 'index'])->name('category.index');
    // Route cho Danh mục sản phẩm
    Route::prefix('category')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('category.index');
        Route::get('create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::get('delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
    });

    // Route cho Sản phẩm
    Route::prefix('product')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('product.index');
        Route::get('create', [ProductController::class, 'create'])->name('product.create');
        Route::post('store', [ProductController::class, 'store'])->name('product.store');
        Route::get('show/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');

        //Route cho Kho ảnh
        Route::prefix('image')->group(function () {
            Route::get('', [ProductImageController::class, 'index'])->name('product.image.index');
            Route::post('store', [ProductImageController::class, 'store'])->name('product.image.store');
            Route::get('{product_id}/detail', [ProductImageController::class, 'show'])->name('product.image.detail');
            Route::get('delete/{id}', [ProductImageController::class, 'destroy'])->name('product.image.delete');
        });

    });

});
// Route cho Trang chủ
Route::get('/', function () {
    return view('welcome');
})->name('home');