<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\Transaksi;

class KasirController extends Controller
{
    public function booking(Request $request)
    {
        $lapangans = Lapangan::all();

        $tanggal = $request->tanggal ?? date('Y-m-d');

        $booking = Transaksi::whereDate('created_at', $tanggal)->get();

        return view('kasir.booking', compact('lapangans', 'booking', 'tanggal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'lapangan' => 'required',
            'jam' => 'required',
            'durasi' => 'required',
            'harga' => 'required',
            'total' => 'required',
            'bayar' => 'required',
            'kembalian' => 'required',
        ]);

        $trx = Transaksi::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'lapangan' => $request->lapangan,
            'jam' => $request->jam,
            'durasi' => $request->durasi,
            'harga' => $request->harga,
            'total' => $request->total,
            'bayar' => $request->bayar,
            'kembalian' => $request->kembalian,
        ]);

        return redirect()->route('kasir.struk', $trx->id);
    }

    public function struk($id)
    {
        $data = Transaksi::findOrFail($id);
        return view('kasir.struk', compact('data'));
    }
}
