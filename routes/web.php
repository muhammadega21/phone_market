<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhoneController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login.index');
Route::get('/register', [AuthController::class, 'register'])->name('register.index');

Route::get('/phones', [PhoneController::class, 'index'])->name('phones.index');
Route::get('/phones/{brand}', [PhoneController::class, 'show'])->name('phones.show');
Route::get('/phones/{slug}', [PhoneController::class, 'detail'])->name('phones.detail');

Route::get('/brands/{slug}', [PhoneController::class, 'show'])->name('brands.show');

Route::get('/categories/{slug}', [PhoneController::class, 'show'])->name('categories.show');
