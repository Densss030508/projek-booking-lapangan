<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/* ================= LOGIN ================= */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

/* ================= ADMIN DASHBOARD ================= */
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');

/* ================= LOGOUT ================= */
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {

    // ================= LAPANGAN =================
    Route::get('/admin/lapangan', [ProductController::class, 'index'])->name('lapangan.index');
    Route::get('/admin/lapangan/create', [ProductController::class, 'create'])->name('lapangan.create');
    Route::post('/admin/lapangan/store', [ProductController::class, 'store'])->name('lapangan.store');

    // ================= PENGGUNA =================
    Route::get('/admin/pengguna', function () {
        return view('admin.pengguna.index');
    })->name('pengguna.index');

    // ================= LAPORAN =================
    Route::get('/admin/laporan', function () {
        return view('admin.laporan.index');
    })->name('laporan.index');
});
