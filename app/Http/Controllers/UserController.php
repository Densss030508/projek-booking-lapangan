<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua data user, urut terbaru
        $users = User::latest()->get();

        // Kirim ke view admin.pengguna.index
        return view('admin.pengguna.index', [
            'users' => $users
        ]);
    }
}
