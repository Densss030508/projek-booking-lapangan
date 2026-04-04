<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangan = Lapangan::latest()->get();
        return view('admin.lapangan.index', compact('lapangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'status' => 'required|string',
            'harga' => 'required|numeric',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('lapangan', 'public');
        }

        Lapangan::create([
            'nama' => $request->nama,
            'status' => $request->status,
            'harga' => $request->harga,
            'foto' => $fotoPath,
            'jam_buka' => '08:00',
            'jam_tutup' => '23:00'
        ]);

        return redirect()->back()->with('success', 'Lapangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, $id)
    {
        $lapangan = Lapangan::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'status' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        if ($request->hasFile('foto')) {
            if ($lapangan->foto && Storage::exists('public/' . $lapangan->foto)) {
                Storage::delete('public/' . $lapangan->foto);
            }
            $lapangan->foto = $request->file('foto')->store('lapangan', 'public');
        }

        $lapangan->update([
            'nama' => $request->nama,
            'status' => $request->status,
            'harga' => $request->harga,
        ]);

        return redirect()->back()->with('success', 'Lapangan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $lapangan = Lapangan::findOrFail($id);

        if ($lapangan->foto && Storage::exists('public/' . $lapangan->foto)) {
            Storage::delete('public/' . $lapangan->foto);
        }

        $lapangan->delete();

        return redirect()->back()->with('success', 'Lapangan berhasil dihapus!');
    }

    public function toggleActive($id)
    {
        $lapangan = Lapangan::findOrFail($id);

        if ($lapangan->status === 'nonaktif') {
            $lapangan->status = 'tersedia';
            $pesan = 'diaktifkan kembali';
        } else {
            $lapangan->status = 'nonaktif';
            $pesan = 'dinonaktifkan';
        }

        $lapangan->save();

        return back()->with('success', "Lapangan berhasil {$pesan}!");
    }
}
