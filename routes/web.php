<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;

/* HOME */

Route::get('/', fn() => view('welcome'));

/* LOGIN */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

/* LOGOUT (FIX POST) */
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/* ADMIN */
Route::middleware('auth')->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/lapangan', [ProductController::class, 'index'])->name('lapangan.index');
    Route::get('/lapangan/create', [ProductController::class, 'create'])->name('lapangan.create');
    Route::post('/lapangan/store', [ProductController::class, 'store'])->name('lapangan.store');

    // 🔥 TAMBAHAN EDIT (INI YANG KURANG)
    Route::get('/lapangan/{id}/edit', [ProductController::class, 'edit'])->name('lapangan.edit');

    Route::put('/lapangan/{id}', [ProductController::class, 'update'])->name('lapangan.update');

    // 🔥 BONUS HAPUS (BIAR LENGKAP)
    Route::delete('/lapangan/{id}', [ProductController::class, 'destroy'])->name('lapangan.destroy');

    Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna.index');

    Route::get('/pengguna/create', fn() => view('admin.pengguna.create'))->name('pengguna.create');

    Route::get('/pengguna/{id}/edit', function ($id) {
        $user = \App\Models\User::find($id);
        return view('admin.pengguna.edit', compact('user'));
    })->name('pengguna.edit');

    Route::post('/pengguna/store', [UserController::class, 'store'])->name('pengguna.store');
    Route::put('/pengguna/{id}', [UserController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('pengguna.destroy');

    Route::get('/laporan', fn() => view('admin.laporan.index'))->name('laporan.index');
});


/* KASIR */
Route::middleware('auth')->prefix('kasir')->group(function () {

    Route::get('/dashboard', fn() => view('kasir.dashboard'))->name('kasir.dashboard');
    Route::get('/jadwal', fn() => view('kasir.jadwal'))->name('kasir.jadwal');
    Route::get('/transaksi', fn() => view('kasir.transaksi'))->name('kasir.transaksi');

    // 🔥 FIX booking pakai controller
    Route::get('/booking', [KasirController::class, 'booking'])->name('kasir.booking');

    // 🔥 SIMPAN TRANSAKSI
    Route::post('/transaksi', [KasirController::class, 'store'])->name('kasir.store');

    // 🔥 STRUK
    Route::get('/struk/{id}', [KasirController::class, 'struk'])->name('kasir.struk');
});


/* OWNER */
Route::middleware('auth')->prefix('owner')->group(function () {

    Route::get('/dashboard', fn() => view('owner.dashboard'))->name('owner.dashboard');
    Route::get('/produk', fn() => view('owner.produk'))->name('owner.produk');
    Route::get('/detail', fn() => view('owner.detail'))->name('owner.detail');
    Route::get('/laporan', fn() => view('owner.laporan'))->name('owner.laporan');
    Route::get('/aktivitas', fn() => view('owner.aktivitas'))->name('owner.aktivitas');
});
