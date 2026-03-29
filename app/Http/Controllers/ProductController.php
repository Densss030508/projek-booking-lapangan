<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use Illuminate\Support\Facades\Storage;

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

    // 🔥 TAMBAHAN EDIT
    public function edit($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    // 🔥 TAMBAHAN UPDATE
    public function update(Request $request, $id)
    {
        $lapangan = Lapangan::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'jam_buka' => 'required',
            'jam_tutup' => 'required',
            'foto' => 'nullable|image'
        ]);

        $data = [
            'nama' => $request->nama,
            'harga' => $request->harga,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
        ];

        // kalau upload foto baru
        if ($request->hasFile('foto')) {

            // hapus foto lama
            if ($lapangan->foto) {
                Storage::disk('public')->delete($lapangan->foto);
            }

            $data['foto'] = $request->file('foto')->store('lapangan', 'public');
        }

        $lapangan->update($data);

        return redirect()->route('lapangan.index')
            ->with('success', 'Lapangan berhasil diupdate');
    }

    // 🔥 TAMBAHAN HAPUS
    public function destroy($id)
    {
        $lapangan = Lapangan::findOrFail($id);

        if ($lapangan->foto) {
            Storage::disk('public')->delete($lapangan->foto);
        }

        $lapangan->delete();

        return redirect()->route('lapangan.index')
            ->with('success', 'Lapangan berhasil dihapus');
    }
}
