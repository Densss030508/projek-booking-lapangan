<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\LogActivityController;

/* HOME */

Route::get('/', fn() => view('welcome'));

/* LOGIN */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

/* LOGOUT */
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/* =========================
   ADMIN
========================= */
Route::prefix('admin')->middleware(['force.app', 'auth'])->group(function () {

    Route::middleware('auth')->group(function () {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            abort(403);
        }
    });

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/lapangan', [ProductController::class, 'index'])->name('lapangan.index');
    Route::get('/lapangan/create', [ProductController::class, 'create'])->name('lapangan.create');
    Route::post('/lapangan/store', [ProductController::class, 'store'])->name('lapangan.store');
    Route::get('/lapangan/{id}/edit', [ProductController::class, 'edit'])->name('lapangan.edit');
    Route::put('/lapangan/{id}', [ProductController::class, 'update'])->name('lapangan.update');
    Route::delete('/lapangan/{id}', [ProductController::class, 'destroy'])->name('lapangan.destroy');
    Route::patch('/lapangan/{id}/toggle-active', [LapanganController::class, 'toggleActive'])->name('lapangan.toggleActive');

    Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/create', [UserController::class, 'create'])->name('pengguna.create');
    Route::get('/pengguna/{id}/edit', [UserController::class, 'edit'])->name('pengguna.edit');
    Route::post('/pengguna/store', [UserController::class, 'store'])->name('pengguna.store');
    Route::put('/pengguna/{id}', [UserController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('pengguna.destroy');
    Route::patch('/pengguna/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('pengguna.toggleStatus');

    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan.index');
});


/* KASIR */
Route::prefix('kasir')->middleware(['force.app', 'auth'])->group(function () {

    Route::middleware('auth')->group(function () {
        if (Auth::check() && Auth::user()->role !== 'kasir') {
            abort(403);
        }
    });

    Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('kasir.dashboard');
    Route::get('/jadwal', [KasirController::class, 'jadwal'])->name('kasir.jadwal');
    Route::get('/dashboard-filter', [KasirController::class, 'dashboardFilter'])->name('kasir.dashboardFilter');

    Route::get('/transaksi', [KasirController::class, 'transaksi'])->name('kasir.transaksi');
    Route::get('/booking', [KasirController::class, 'booking'])->name('kasir.booking');

    Route::post('/transaksi', [KasirController::class, 'store'])->name('kasir.store');
    Route::get('/struk/{id}', [KasirController::class, 'struk'])->name('kasir.struk');
});


/* OWNER */
Route::prefix('owner')->middleware(['force.app', 'auth'])->group(function () {

    Route::middleware('auth')->group(function () {
        if (Auth::check() && Auth::user()->role !== 'owner') {
            abort(403);
        }
    });

    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
    Route::get('/produk', [OwnerController::class, 'produk'])->name('owner.produk');
    Route::get('/detail/{id}', [OwnerController::class, 'detail'])->name('owner.detail');
    Route::get('/laporan', [OwnerController::class, 'laporan'])->name('owner.laporan');
    Route::get('/laporan/excel', [OwnerController::class, 'exportExcel'])->name('owner.exportExcel');
    Route::get('/laporan/pdf', [OwnerController::class, 'exportPdf'])->name('owner.exportPdf');

    Route::get('/aktivitas', [OwnerController::class, 'aktivitas'])->name('owner.aktivitas');
    Route::get('/log-activity', [LogActivityController::class, 'index'])->name('log-activity.index');
    Route::get('/log-sidebar', [OwnerController::class, 'aktivitas'])->name('log.sidebar');
});
