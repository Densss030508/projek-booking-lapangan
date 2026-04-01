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
            return back()->withErrors(['username' => 'User tidak ditemukan']);
        }

        if ($user->status != 'aktif') {
            return back()->withErrors(['username' => 'User tidak aktif']);
        }

        if (!Hash::check($password, $user->password)) {
            return back()->withErrors(['username' => 'Password salah']);
        }

        Auth::loginUsingId($user->id);
        $request->session()->regenerate();

        // 🔥 Catat log login
        LogAktivitas::create([
            'id_user'  => $user->id,
            'activity' => 'Login sebagai ' . ucfirst($user->role),
        ]);

        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'kasir') {
            return redirect()->route('kasir.dashboard');
        } elseif ($user->role == 'owner') {
            return redirect()->route('owner.dashboard');
        }

        return redirect('/');
    }

    public function logout(Request $request)
    {
        // 🔥 Catat log logout sebelum session dihapus
        if (Auth::check()) {
            LogAktivitas::create([
                'id_user'  => Auth::id(),
                'activity' => 'Logout dari sistem',
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
                'Pragma'        => 'no-cache',
                'Expires'       => 'Sat, 01 Jan 1990 00:00:00 GMT',
            ]);
    }
}
