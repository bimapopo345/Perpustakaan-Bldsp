<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/book/{book}', [HomeController::class, 'showBook'])->name('book.show');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Books CRUD
    Route::resource('books', BookController::class);
});

// Auth Routes
Route::get('/admin/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/admin/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
