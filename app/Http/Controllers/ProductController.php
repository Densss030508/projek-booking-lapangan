<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;

class ProductController extends Controller
{
    public function index()
    {
        $lapangan = Lapangan::all();
        return view('admin.lapangan.index', compact('lapangan'));
    }

    public function create()
    {
        return view('admin.lapangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
            'foto' => 'required|image'
        ]);

        // upload foto
        $foto = $request->file('foto')->store('lapangan', 'public');

        Lapangan::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'foto' => $foto,
            'status' => 'tersedia'
        ]);

        return redirect()->route('lapangan.index')
            ->with('success', 'Lapangan berhasil ditambahkan');
    }
}
