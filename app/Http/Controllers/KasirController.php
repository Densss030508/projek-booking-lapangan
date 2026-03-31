<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Lapangan;

class KasirController extends Controller
{
    public function dashboard()
    {
        // 🔥 tanggal hari ini
        $today = date('Y-m-d');

        // 🔥 jumlah booking hari ini
        $jumlahBooking = Transaksi::whereDate('tanggal', $today)->count();

        // 🔥 total transaksi hari ini
        $totalTransaksi = Transaksi::whereDate('tanggal', $today)->sum('total');

        // 🔥 jumlah lapangan
        $jumlahLapangan = Lapangan::count();

        // 🔥 ambil data jadwal hari ini
        $transaksiHariIni = Transaksi::whereDate('tanggal', $today)->get();
        $lapangans = Lapangan::all();

        return view('kasir.dashboard', compact(
            'jumlahBooking',
            'totalTransaksi',
            'jumlahLapangan',
            'transaksiHariIni',
            'lapangans'
        ));
    }

    public function booking()
    {
        $lapangans = Lapangan::all();
        $transaksi = Transaksi::all();

        return view('kasir.booking', compact('lapangans', 'transaksi'));
    }

    public function transaksi()
    {
        $transaksi = Transaksi::latest()->get();
        return view('kasir.transaksi', compact('transaksi'));
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
            'bayar' => 'required',
            'tanggal' => 'required',
        ]);

        $harga = (int) str_replace('.', '', $request->harga);
        $bayar = (int) str_replace('.', '', $request->bayar);
        $durasi = (int) $request->durasi;

        $total = $harga * $durasi;
        $kembalian = $bayar - $total;

        $jam = $request->jam;

        $kode = 'TRX-' . now()->format('Ymd') . '-' . rand(100, 999);

        $transaksi = Transaksi::create([
            'kode_transaksi' => $kode,
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'lapangan' => $request->lapangan,
            'jam' => $jam,
            'durasi' => $durasi,
            'harga' => $harga,
            'total' => $total,
            'bayar' => $bayar,
            'kembalian' => $kembalian,
        ]);

        return redirect()->route('kasir.booking')
            ->with('success', 'Transaksi berhasil disimpan!')
            ->with('last_id', $transaksi->id);
    }

    public function struk($id)
    {
        $data = Transaksi::findOrFail($id);
        return view('kasir.struk', compact('data'));
    }

    public function jadwal()
    {
        return view('kasir.jadwal');
    }
}
