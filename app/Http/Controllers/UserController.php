<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.pengguna.index', compact('users'));
    }

    public function create()
    {
        $ownerSudahAda = User::where('role', 'owner')->exists();
        $adminSudahAda = User::where('role', 'admin')->exists();

        return view('admin.pengguna.create', compact(
            'ownerSudahAda',
            'adminSudahAda'
        ));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.pengguna.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'status' => 'required',
            'password' => 'required|confirmed|min:5'
        ]);

        if ($request->role === 'owner') {
            $ownerSudahAda = User::where('role', 'owner')->exists();

            if ($ownerSudahAda) {
                return back()->withInput()
                    ->with('error', 'Role owner hanya boleh 1 akun!');
            }
        }

        if ($request->role === 'admin') {
            $adminSudahAda = User::where('role', 'admin')->exists();

            if ($adminSudahAda) {
                return back()->withInput()
                    ->with('error', 'Role admin hanya boleh 1 akun!');
            }
        }

        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->email,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'password' => bcrypt($request->password),
        ]);

        LogAktivitas::create([
            'id_user' => Auth::id(),
            'activity' => 'Menambahkan user baru: ' . $user->nama
        ]);

        return redirect()->route('pengguna.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|confirmed|min:5'
        ]);

        $statusBaru = $user->status;

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

        LogAktivitas::create([
            'id_user' => Auth::id(),
            'activity' => 'Mengubah data user: ' . $user->nama
        ]);

        return back()->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() == $user->id) {
            return back()->with('error', 'Tidak bisa hapus akun sendiri');
        }

        if ($user->role === 'owner') {
            return back()->with('error', 'Role owner tidak boleh dihapus!');
        }

        $namaUser = $user->nama;

        $user->delete();

        LogAktivitas::create([
            'id_user' => Auth::id(),
            'activity' => 'Menghapus user: ' . $namaUser
        ]);

        return redirect()->route('pengguna.index')
            ->with('success', 'User berhasil dihapus!');
    }

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

        LogAktivitas::create([
            'id_user' => Auth::id(),
            'activity' => 'Mengubah status user ' . $user->nama . ' menjadi ' . $user->status
        ]);

        $pesan = $user->status === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "User berhasil {$pesan}!");
    }
}
