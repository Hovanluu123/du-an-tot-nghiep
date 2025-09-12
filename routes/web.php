<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;

// Public shop routes
Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/san-pham', [ShopController::class, 'products'])->name('shop.products');
Route::get('/san-pham/{slug}', [ShopController::class, 'product'])->name('shop.product');

// Cart
Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang/them/{productId}', [CartController::class, 'add'])->name('cart.add');
Route::post('/gio-hang/cap-nhat/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::post('/gio-hang/xoa/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/gio-hang/xoa-tat-ca', [CartController::class, 'clear'])->name('cart.clear');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        // Admin home -> redirect to categories
        Route::get('/', function () {
            return redirect()->route('admin.categories.index');
        })->name('home');
        // Categories
        Route::resource('categories', \App\Http\Controllers\CategoryController::class);
        
        // Products
        Route::resource('products', \App\Http\Controllers\ProductController::class);
    });
});
