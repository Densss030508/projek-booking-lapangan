<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $login = $request->username;
        $password = $request->password;

        // cek email atau username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([
            $field => $login,
            'password' => $password
        ])) {

            $request->session()->regenerate();

            // 🔥 TAMBAHAN: HANDLE AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => Auth::user()->role == 'admin'
                        ? route('admin.dashboard')
                        : url('/')
                ]);
            }

            // 🔥 DEFAULT (TIDAK DIHAPUS)
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect('/');
        }

        // 🔥 TAMBAHAN: ERROR AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Email / Username atau password salah.'
            ]);
        }

        // 🔥 DEFAULT (TIDAK DIHAPUS)
        return back()->withErrors([
            'username' => 'Email / Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
