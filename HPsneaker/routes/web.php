<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\client\ContactClientController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\CommentController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\client\ContactClientController as ClientContactClientController;

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
            Route::get('', [UserController::class, 'index'])->name('user.index');
            Route::get('create', [UserController::class, 'create'])->name('user.create');
            Route::post('store', [UserController::class, 'store'])->name('user.store');
            Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
            Route::post('update/{id}', [UserController::class, 'update'])->name('user.update');
            Route::get('delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
            Route::get('show/{id}', [UserController::class, 'show'])->name('user.show');
        });

        // Quản lý contact
        Route::prefix('contact')->group(function () {
            Route::get('', [ContactController::class, 'index'])->name('contact.index');
            Route::get('delete/{id}', [ContactController::class, 'delete'])->name('contact.delete');
            Route::get('show/{id}', [ContactController::class, 'show'])->name('contact.show');

        });

        // Quản lý bình luận
        Route::prefix('comment')->group(function () {
            Route::get('', [CommentController::class, 'index'])->name('comment.index');
            Route::get('delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');
            Route::get('show/{id}', [CommentController::class, 'show'])->name('comment.show');

        });

    });
});

// Route cho Trang chủ
Route::get('/', function () {
    return view('viewers.home.index');
});
        Route::prefix('contact')->group(function () {
            Route::get('', [ContactClientController::class, 'index'])->name('client.contact.index');
            Route::post('', [ContactClientController::class, 'submit'])->name('client.contact.submit');

});

