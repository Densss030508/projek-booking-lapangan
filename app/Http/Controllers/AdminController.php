<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Lapangan;
use App\Models\Transaksi;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUser = User::count();

        $totalLapangan = Lapangan::where('status', '!=', 'nonaktif')->count();

        $nonAktif = User::where('status', 'nonaktif')->count();

        $users = User::latest()->get();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalLapangan',
            'nonAktif',
            'users'
        ));
    }


    public function laporan()
    {
        $transaksi = Transaksi::latest()->get();

        return view('admin.laporan.index', compact('transaksi'));
    }
}
