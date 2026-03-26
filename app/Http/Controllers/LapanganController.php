<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    // 🔹 Tampilkan semua lapangan
    public function index()
    {
        $lapangan = Lapangan::all();
        return view('admin.lapangan.index', compact('lapangan'));
    }

    // 🔹 Form tambah (optional kalau pakai modal bisa tidak dipakai)
    public function create()
    {
        return view('admin.lapangan.create');
    }

    // 🔹 Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'status' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'required|image'
        ]);

        $foto = $request->file('foto')->store('lapangan', 'public');

        Lapangan::create([
            'nama' => $request->nama,
            'status' => $request->status,
            'harga' => $request->harga,
            'foto' => $foto,
            'jam_buka' => '08:00',
            'jam_tutup' => '23:00'
        ]);

        return redirect()->back()->with('success', 'Lapangan berhasil ditambahkan!');
    }

    // 🔹 Form edit (kalau pakai modal, ini optional)
    public function edit($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    // 🔹 Update data
    public function update(Request $request, $id)
    {
        $lapangan = Lapangan::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'status' => 'required',
            'harga' => 'required|numeric',
        ]);

        // Jika upload foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($lapangan->foto && Storage::exists('public/' . $lapangan->foto)) {
                Storage::delete('public/' . $lapangan->foto);
            }

            // Simpan foto baru
            $foto = $request->file('foto')->store('lapangan', 'public');
            $lapangan->foto = $foto;
        }

        // Update data
        $lapangan->update([
            'nama' => $request->nama,
            'status' => $request->status,
            'harga' => $request->harga,
        ]);

        return redirect()->back()->with('success', 'Lapangan berhasil diperbarui!');
    }

    // 🔹 Hapus data
    public function destroy($id)
    {
        $lapangan = Lapangan::findOrFail($id);

        // Hapus foto
        if ($lapangan->foto && Storage::exists('public/' . $lapangan->foto)) {
            Storage::delete('public/' . $lapangan->foto);
        }

        $lapangan->delete();

        return redirect()->back()->with('success', 'Lapangan berhasil dihapus!');
    }
}
