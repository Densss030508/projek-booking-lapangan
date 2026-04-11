<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.pengguna.index', compact('users'));
    }

    public function create()
    {
        $adminSudahAda = User::where('role', 'admin')->exists();
        $ownerSudahAda = User::where('role', 'owner')->exists();

        return view('admin.pengguna.create', compact(
            'adminSudahAda',
            'ownerSudahAda'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required',
            'status' => 'required'
        ]);

        // admin hanya 1
        if ($request->role === 'admin' && User::where('role', 'admin')->exists()) {
            return back()->withInput()->with('error', 'Admin hanya boleh 1 akun');
        }

        // owner hanya 1
        if ($request->role === 'owner' && User::where('role', 'owner')->exists()) {
            return back()->withInput()->with('error', 'Owner hanya boleh 1 akun');
        }

        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status
        ]);

        LogAktivitas::create([
            'id_user' => Auth::id(),
            'activity' => 'Menambahkan pengguna: ' . $user->nama
        ]);

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan');
    }
}
