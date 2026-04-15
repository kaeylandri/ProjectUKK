<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AspirasiController; // TAMBAHKAN INI
use Illuminate\Support\Facades\Route;

/* ── Root redirect ── */
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});

/* ── Auth (guest only) ── */
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class,   'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class,   'login'])->name('login.post');
    Route::get('/register',  [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')->middleware('auth');

/* ── Admin Routes ── */
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard',           [AdminController::class, 'dashboard'])->name('dashboard');
        
        // GASUKAN ROUTE ASPIRASI DARI ASPIRASICONTROLLER
        Route::get('/aspirasi',            [AspirasiController::class, 'adminIndex'])->name('aspirasi');
        Route::post('/aspirasi/{id}/status', [AspirasiController::class, 'updateStatus'])->name('aspirasi.updateStatus');
        Route::put('/aspirasi/{aspirasi}', [AspirasiController::class, 'update'])->name('aspirasi.update');
        
        Route::get('/users',               [AdminController::class, 'users'])->name('users');
        Route::get('/users/create',        [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users',              [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit',   [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}',        [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}',     [AdminController::class, 'deleteUser'])->name('users.delete');
    });

/* ── User (Siswa) Routes ── */
Route::middleware(['auth', 'role:user'])
    ->prefix('siswa')->name('user.')
    ->group(function () {
        Route::get('/dashboard',           [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/aspirasi/buat',       [AspirasiController::class, 'create'])->name('aspirasi.create');
        Route::post('/aspirasi',           [AspirasiController::class, 'store'])->name('aspirasi.store');
        Route::get('/aspirasi',            [AspirasiController::class, 'index'])->name('aspirasi.list');
        Route::get('/aspirasi/{aspirasi}', [AspirasiController::class, 'show'])->name('aspirasi.show');
    });