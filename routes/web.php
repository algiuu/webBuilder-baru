<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:admin')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:login');
});

Route::middleware('auth:admin')->group(function (): void {
    Route::get('/', AdminDashboardController::class)->name('admin.dashboard');
    Route::get('/websites/create', [WebsiteController::class, 'create'])->name('websites.create');
    Route::post('/websites', [WebsiteController::class, 'store'])->name('websites.store');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::get('/{website:slug}', [WebsiteController::class, 'show'])->name('websites.show');
