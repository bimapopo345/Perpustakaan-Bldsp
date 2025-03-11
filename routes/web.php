<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/book/{id}', [HomeController::class, 'show'])->name('book.show');
Route::get('/book/{id}/read', [BookController::class, 'read'])->name('books.read');
Route::get('/book/{id}/pdf', [BookController::class, 'viewPdf'])->name('books.view-pdf');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
    
    // Register Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.attempt');
});

// Member Routes
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
    
    // Peminjaman Routes
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/book/pinjam/{id}', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/book/pinjam', [PeminjamanController::class, 'store'])->name('peminjaman.store');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('books', AdminBookController::class);
        Route::get('/members', [AdminMemberController::class, 'index'])->name('members.index');
        
        // Admin Peminjaman Routes
        Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::post('/peminjaman/{id}/approve', [AdminPeminjamanController::class, 'approve'])->name('peminjaman.approve');
        Route::post('/peminjaman/{id}/reject', [AdminPeminjamanController::class, 'reject'])->name('peminjaman.reject');
        Route::post('/peminjaman/{id}/return', [AdminPeminjamanController::class, 'return'])->name('peminjaman.return');
    });
