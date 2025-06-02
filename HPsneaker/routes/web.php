<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\UserController;
// Route cho Admin
Route::prefix('admin')->group(function () {
    // Form login và xử lý login KHÔNG cần middleware
    Route::get('', [LoginController::class, 'LoginForm'])->name('admin.form');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');

    // Các route CẦN middleware
    Route::middleware(['admin.login'])->group(function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');

        // Danh mục
        Route::prefix('category')->group(function () {
            Route::get('', [CategoryController::class, 'index'])->name('category.index');
            Route::get('create', [CategoryController::class, 'create'])->name('category.create');
            Route::post('store', [CategoryController::class, 'store'])->name('category.store');
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
            Route::post('update/{id}', [CategoryController::class, 'update'])->name('category.update');
            Route::get('delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
        });

        // Sản phẩm
        Route::prefix('product')->group(function () {
            Route::get('', [ProductController::class, 'index'])->name('product.index');
            Route::get('create', [ProductController::class, 'create'])->name('product.create');
            Route::post('store', [ProductController::class, 'store'])->name('product.store');
            Route::get('show/{id}', [ProductController::class, 'show'])->name('product.show');
            Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
            Route::post('update/{id}', [ProductController::class, 'update'])->name('product.update');
            Route::get('delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');

            // Kho ảnh
            Route::prefix('image')->group(function () {
                Route::get('', [ProductImageController::class, 'index'])->name('product.image.index');
                Route::post('store', [ProductImageController::class, 'store'])->name('product.image.store');
                Route::get('{product_id}/detail', [ProductImageController::class, 'show'])->name('product.image.detail');
                Route::get('delete/{id}', [ProductImageController::class, 'destroy'])->name('product.image.delete');
            });
        });

        // Quản lý người dùng
        Route::prefix('user')->group(function () {
            Route::get('', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
            Route::get('create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
            Route::post('store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
            Route::get('edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
            Route::post('update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
            Route::get('delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.delete');
        });
    });
});

// Route cho Trang chủ
Route::get('/', function () {
    return view('welcome');
})->name('home');
