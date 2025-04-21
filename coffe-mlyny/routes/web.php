<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;

Route::get('/', [LandingController::class, 'index']);
Route::get('/catalogue', [ProductController::class, 'index'])->name('catalogue');
Route::view('/about', 'about');
Route::view('/contact', 'contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/products', [ProductController::class, 'index']);