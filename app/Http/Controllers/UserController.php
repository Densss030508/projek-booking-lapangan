<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.pengguna.index', compact('users'));
    }

    // ✅ CREATE PAGE
    public function create()
    {
        $ownerSudahAda = User::where('role', 'owner')->exists();
        $adminSudahAda = User::where('role', 'admin')->exists();

        return view('admin.pengguna.create', compact(
            'ownerSudahAda',
            'adminSudahAda'
        ));
    }

    // ✅ EDIT PAGE (FIX ERROR)
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.pengguna.edit', compact('user'));
    }

    // ✅ STORE USER
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'status' => 'required',
            'password' => 'required|confirmed|min:5'
        ]);

        // ✅ OWNER HANYA 1
        if ($request->role === 'owner') {
            $ownerSudahAda = User::where('role', 'owner')->exists();

            if ($ownerSudahAda) {
                return back()->withInput()
                    ->with('error', 'Role owner hanya boleh 1 akun!');
            }
        }

        // ✅ ADMIN HANYA 1
        if ($request->role === 'admin') {
            $adminSudahAda = User::where('role', 'admin')->exists();

            if ($adminSudahAda) {
                return back()->withInput()
                    ->with('error', 'Role admin hanya boleh 1 akun!');
            }
        }

        User::create([
            'nama' => $request->nama,
            'username' => $request->email,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('pengguna.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    // ✅ UPDATE USER
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|confirmed|min:5'
        ]);

        $statusBaru = $user->status;

        // ✅ OWNER SELALU AKTIF
        if ($user->role !== 'owner') {
            $statusBaru = $request->status ?? $user->status;
        }

        $user->update([
            'nama' => $request->nama,
            'username' => $request->email,
            'email' => $request->email,
            'status' => $statusBaru,
            'password' => $request->password
                ? bcrypt($request->password)
                : $user->password
        ]);

        return back()->with('success', 'User berhasil diperbarui!');
    }

    // ✅ DELETE USER
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() == $user->id) {
            return back()->with('error', 'Tidak bisa hapus akun sendiri');
        }

        if ($user->role === 'owner') {
            return back()->with('error', 'Role owner tidak boleh dihapus!');
        }

        $user->delete();

        return redirect()->route('pengguna.index')
            ->with('success', 'User berhasil dihapus!');
    }

    // ✅ TOGGLE STATUS
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() == $user->id) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri!');
        }

        if ($user->role === 'owner') {
            return back()->with('error', 'Role owner tidak boleh dinonaktifkan!');
        }

        $user->status = ($user->status === 'aktif') ? 'nonaktif' : 'aktif';
        $user->save();

        $pesan = $user->status === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "User berhasil {$pesan}!");
    }
}
