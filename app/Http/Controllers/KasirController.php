<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Lapangan;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function dashboard()
    {
        $today = date('Y-m-d');

        $jumlahBooking  = Transaksi::whereDate('tanggal', $today)->count();
        $totalTransaksi = Transaksi::whereDate('tanggal', $today)->sum('total');
        $jumlahLapangan = Lapangan::count();
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

    public function dashboardFilter(Request $request)
    {
        $tanggal = $request->tanggal;

        $jumlahBooking  = Transaksi::whereDate('tanggal', $tanggal)->count();
        $totalTransaksi = Transaksi::whereDate('tanggal', $tanggal)->sum('total');
        $transaksiHariIni = Transaksi::whereDate('tanggal', $tanggal)->get();
        $lapangans = Lapangan::all();

        $jadwal = [];
        for ($i = 8; $i <= 12; $i++) {
            $row = ['jam' => sprintf('%02d.00', $i), 'lapangans' => []];
            foreach ($lapangans as $lap) {
                $booked = false;
                foreach ($transaksiHariIni as $trx) {
                    if ($trx->lapangan == $lap->nama) {
                        if (str_contains($trx->jam, '-')) {
                            $range = explode('-', $trx->jam);
                            $start = (int) date('H', strtotime(trim($range[0])));
                            $end   = (int) date('H', strtotime(trim($range[1])));
                            if ($i >= $start && $i <= $end) {
                                $booked = true;
                                break;
                            }
                        } else {
                            foreach (explode(',', $trx->jam) as $j) {
                                if ($i == (int) date('H', strtotime(trim($j)))) {
                                    $booked = true;
                                    break;
                                }
                            }
                        }
                    }
                }
                $row['lapangans'][] = ['nama' => $lap->nama, 'booked' => $booked];
            }
            $jadwal[] = $row;
        }

        return response()->json([
            'jumlahBooking'  => $jumlahBooking,
            'totalTransaksi' => 'Rp ' . number_format($totalTransaksi, 0, ',', '.'),
            'jadwal'         => $jadwal,
        ]);
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
            'nama'     => 'required',
            'no_hp'    => 'required',
            'lapangan' => 'required',
            'jam'      => 'required',
            'durasi'   => 'required',
            'harga'    => 'required',
            'bayar'    => 'required',
            'tanggal'  => 'required',
        ]);

        $harga     = (int) str_replace('.', '', $request->harga);
        $bayar     = (int) str_replace('.', '', $request->bayar);
        $durasi    = (int) $request->durasi;
        $total     = $harga * $durasi;
        $kembalian = $bayar - $total;
        $kode      = 'TRX-' . now()->format('Ymd') . '-' . rand(100, 999);

        $transaksi = Transaksi::create([
            'kode_transaksi' => $kode,
            'tanggal'        => $request->tanggal,
            'nama'           => $request->nama,
            'no_hp'          => $request->no_hp,
            'lapangan'       => $request->lapangan,
            'jam'            => $request->jam,
            'durasi'         => $durasi,
            'harga'          => $harga,
            'total'          => $total,
            'bayar'          => $bayar,
            'kembalian'      => $kembalian,
        ]);

        // 🔥 Catat log transaksi
        LogAktivitas::create([
            'id_user'  => Auth::id(),
            'activity' => 'Membuat transaksi booking ' . $request->lapangan .
                ' atas nama ' . $request->nama .
                ' jam ' . $request->jam .
                ' tanggal ' . $request->tanggal,
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
