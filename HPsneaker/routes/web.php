<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
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

    // ... các resource khác cho admin
});
// Route cho Trang chủ
Route::get('/', function () {
    return view('welcome');
})->name('home');