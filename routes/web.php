<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhoneController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/phones/{id}', [PhoneController::class, 'index'])->name('phones.show');

Route::get('/brands/{id}', [PhoneController::class, 'index'])->name('brands.show');

Route::get('/categories/{id}', [PhoneController::class, 'index'])->name('categories.show');
