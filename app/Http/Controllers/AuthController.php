<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // 🔹 Tampilkan halaman login
    public function showLogin()
    {
        return view('login');
    }

    // 🔹 Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $login = $request->username;
        $password = $request->password;

        // cari user
        $user = User::where('username', $login)
            ->orWhere('email', $login)
            ->first();

        // user tidak ditemukan
        if (!$user) {
            return back()->withErrors(['username' => 'User tidak ditemukan']);
        }

        // status tidak aktif
        if ($user->status != 'aktif') {
            return back()->withErrors(['username' => 'User tidak aktif']);
        }

        // password salah
        if (!Hash::check($password, $user->password)) {
            return back()->withErrors(['username' => 'Password salah']);
        }

        // login
        Auth::loginUsingId($user->id);

        // regenerate session
        $request->session()->regenerate();

        // redirect sesuai role
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'kasir') {
            return redirect()->route('kasir.dashboard');
        } elseif ($user->role == 'owner') {
            return redirect()->route('owner.dashboard');
        }

        return redirect('/');
    }

    // 🔹 LOGOUT (🔥 FIX UTAMA)
    public function logout(Request $request)
    {
        Auth::logout();

        // hapus session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 🔥 FIX: arahkan ke welcome (SAMA SEMUA ROLE)
        return redirect('/')
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 01 Jan 1990 00:00:00 GMT',
            ]);
    }
}
