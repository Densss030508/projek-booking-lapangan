<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PenggunaController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('pengguna.index', compact('users'));
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success','Pengguna berhasil ditambahkan');
    }

}
