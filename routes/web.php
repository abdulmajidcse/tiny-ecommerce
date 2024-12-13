<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('product-details/{product}', [FrontendController::class, 'productDetails'])->name('productDetails');

// cart routes
Route::prefix('carts')->name('carts.')->group(function() {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('{product}', [CartController::class, 'storeOrUpdate'])->name('storeOrUpdate');
    Route::delete('{cart?}', [CartController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('products', ProductController::class);
});

require __DIR__ . '/auth.php';
