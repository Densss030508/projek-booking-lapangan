<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Lapangan;
use App\Models\Transaksi; // 🔥 WAJIB TAMBAH INI

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUser = User::count();
        $totalLapangan = Lapangan::count();
        $nonAktif = User::where('status', 'nonaktif')->count();

        $users = User::latest()->get();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalLapangan',
            'nonAktif',
            'users'
        ));
    }

    // 🔥 TAMBAHAN BARU (INI YANG PENTING)
    public function laporan()
    {
        $transaksi = Transaksi::latest()->get(); // ambil dari kasir

        return view('admin.laporan.index', compact('transaksi'));
    }
}
