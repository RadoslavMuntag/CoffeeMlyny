<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;


Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/catalogue', [ProductController::class, 'index'])->name('catalogue');
Route::view('/about', 'about');
Route::view('/contact', 'contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/account', [AccountController::class, 'index'])->middleware('auth')->name('account');
Route::put('/account', [AccountController::class, 'update'])->middleware('auth')->name('account.update');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/checkout/update', [CheckoutController::class, 'update'])->name('checkout.update');
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => view('admin.dashboard'))->name('dashboard');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/admin/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/admin/orders/{order}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::resource('products', AdminProductController::class);
    Route::post('/products/{product}/add-stock', [AdminProductController::class, 'updateStock'])->name('products.updateStock');
    Route::delete('/products/images/{image}', [AdminProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::put('/users/{user}/toggle-role', [UserController::class, 'toggleRole'])->name('users.toggleRole');
});

