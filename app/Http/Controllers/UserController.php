<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 🔹 Tampilkan user
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.pengguna.index', compact('users'));
    }

    // 🔹 Simpan user
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'status' => 'required',
            'password' => 'required|confirmed|min:5'
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->email, // sync username = email
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('pengguna.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    // 🔹 Update user
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'status' => 'required',
            'password' => 'nullable|confirmed|min:5'
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'nama' => $request->nama,
            'username' => $request->email, // 🔥 update juga username
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'password' => $request->password
                ? bcrypt($request->password)
                : $user->password
        ]);

        return back()->with('success', 'User berhasil diperbarui!');
    }

    // 🔹 Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // tidak boleh hapus diri sendiri
        if (Auth::id() == $user->id) {
            return back()->with('error', 'Tidak bisa hapus akun sendiri');
        }

        $user->delete();

        return redirect()->route('pengguna.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
