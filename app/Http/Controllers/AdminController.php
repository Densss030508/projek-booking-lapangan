<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Lapangan;

class AdminController extends Controller
{
    public function dashboard()
    {

        $totalUser = User::count();
        $totalLapangan = Lapangan::count();
        $nonAktif = User::where('status', 'nonaktif')->count();

        $users = User::all();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalLapangan',
            'nonAktif',
            'users'
        ));
    }
}
