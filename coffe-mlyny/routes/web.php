<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index']);
Route::view('/catalogue', 'catalogue');
Route::view('/about', 'about');
Route::view('/contact', 'contact');