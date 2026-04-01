<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
            'nama'      => 'required',
            'harga'     => 'required|numeric',
            'jam_buka'  => 'required',
            'jam_tutup' => 'required',
            'foto'      => 'required|image'
        ]);

        $foto = $request->file('foto')->store('lapangan', 'public');

        Lapangan::create([
            'nama'      => $request->nama,
            'harga'     => $request->harga,
            'jam_buka'  => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'foto'      => $foto,
            'status'    => 'tersedia'
        ]);

        // 🔥 Log
        LogAktivitas::create([
            'id_user'  => Auth::id(),
            'activity' => 'Menambah lapangan baru: ' . $request->nama,
        ]);

        return redirect()->route('lapangan.index')
            ->with('success', 'Lapangan berhasil ditambahkan');
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
            'nama'      => 'required',
            'harga'     => 'required|numeric',
            'jam_buka'  => 'required',
            'jam_tutup' => 'required',
            'foto'      => 'nullable|image'
        ]);

        $data = [
            'nama'      => $request->nama,
            'harga'     => $request->harga,
            'jam_buka'  => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
        ];

        if ($request->hasFile('foto')) {
            if ($lapangan->foto) {
                Storage::disk('public')->delete($lapangan->foto);
            }
            $data['foto'] = $request->file('foto')->store('lapangan', 'public');
        }

        $lapangan->update($data);

        // 🔥 Log
        LogAktivitas::create([
            'id_user'  => Auth::id(),
            'activity' => 'Mengubah data lapangan: ' . $request->nama,
        ]);

        return redirect()->route('lapangan.index')
            ->with('success', 'Lapangan berhasil diupdate');
    }

    public function destroy($id)
    {
        $lapangan = Lapangan::findOrFail($id);

        // 🔥 Simpan nama dulu sebelum dihapus
        $namaLapangan = $lapangan->nama;

        if ($lapangan->foto) {
            Storage::disk('public')->delete($lapangan->foto);
        }

        $lapangan->delete();

        // 🔥 Log
        LogAktivitas::create([
            'id_user'  => Auth::id(),
            'activity' => 'Menghapus lapangan: ' . $namaLapangan,
        ]);

        return redirect()->route('lapangan.index')
            ->with('success', 'Lapangan berhasil dihapus');
    }
}
