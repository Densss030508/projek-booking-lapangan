<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/* ================= HOME ================= */

Route::get('/', function () {
    return view('welcome');
});

/* ================= LOGIN ================= */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

/* ================= LOGOUT ================= */
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* ================= ADMIN ================= */
Route::middleware('auth')->group(function () {

    // DASHBOARD
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // LAPANGAN
    Route::get('/admin/lapangan', [ProductController::class, 'index'])->name('lapangan.index');
    Route::get('/admin/lapangan/create', [ProductController::class, 'create'])->name('lapangan.create');
    Route::post('/admin/lapangan/store', [ProductController::class, 'store'])->name('lapangan.store');

    // PENGGUNA
    Route::get('/admin/pengguna', [UserController::class, 'index'])->name('pengguna.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/admin/pengguna/create', function () {
        return view('admin.pengguna.create');
    })->name('pengguna.create');

    Route::get('/admin/pengguna/{id}/edit', function ($id) {
        $user = \App\Models\User::find($id);
        return view('admin.pengguna.edit', compact('user'));
    })->name('pengguna.edit');

    // 🔥 TAMBAHAN FIX (PENTING BANGET, TIDAK MENGHAPUS)
    Route::post('/admin/pengguna/create', function () {
        return redirect('/admin/pengguna/create');
    });

    // 🔥 INI SUDAH BENAR (JANGAN DIUBAH LAGI)
    Route::post('/admin/pengguna/store', [UserController::class, 'store'])->name('pengguna.store');

    Route::put('/admin/pengguna/{id}', [UserController::class, 'update'])->name('pengguna.update');

    // 🔥 DELETE
    Route::delete('/admin/pengguna/{id}', [UserController::class, 'destroy'])->name('pengguna.destroy');

    // LAPORAN
    Route::get('/admin/laporan', function () {
        return view('admin.laporan.index');
    })->name('laporan.index');
});
