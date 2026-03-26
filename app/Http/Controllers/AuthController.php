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

        // 🔥 FIX LOGIN (PENTING BANGET)
        Auth::loginUsingId($user->id);

        // regenerate session
        $request->session()->regenerate();

        // redirect admin
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/');
    }

    // 🔹 logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
