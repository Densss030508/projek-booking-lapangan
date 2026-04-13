<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LogAktivitas;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $login    = $request->username;
        $password = $request->password;

        $user = User::where('username', $login)
            ->orWhere('email', $login)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'User tidak ditemukan'
            ]);
        }

        if ($user->status != 'aktif') {
            return back()->withErrors([
                'username' => 'User tidak aktif'
            ]);
        }

        if (!Hash::check($password, $user->password)) {
            return back()->withErrors([
                'username' => 'Password salah'
            ]);
        }

        /*
        =====================================================
        LOGIN FIX STABIL
        =====================================================
        */
        Auth::login($user);

        // regenerate session setelah login
        $request->session()->regenerate();

        // session penanda aplikasi
        $request->session()->put('from_app', true);
        $request->session()->put('role_login_time', now());

        LogAktivitas::create([
            'id_user'  => $user->id,
            'activity' => 'Login sebagai ' . ucfirst($user->role),
        ]);

        /*
        =====================================================
        ROLE REDIRECT
        =====================================================
        */
        $role = strtolower(trim($user->role ?? ''));

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'kasir') {
            return redirect()->route('kasir.dashboard');
        }

        if ($role === 'owner') {
            return redirect()->route('owner.dashboard');
        }

        // fallback kalau role tidak valid
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->withErrors([
            'username' => 'Role tidak valid: ' . $user->role
        ]);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            LogAktivitas::create([
                'id_user'  => Auth::id(),
                'activity' => 'Logout dari sistem',
            ]);
        }

        // logout user
        Auth::logout();

        // hapus semua session
        $request->session()->invalidate();

        // buat token baru
        $request->session()->regenerateToken();

        // 🔥 kembali ke welcome
        return redirect('/')
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
    }
}
