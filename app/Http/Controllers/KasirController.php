<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Lapangan;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KasirController extends Controller
{
    public function dashboard()
    {
        $today = date('Y-m-d');

        $jumlahBooking = Transaksi::whereDate('tanggal', $today)->count();
        $totalTransaksi = Transaksi::whereDate('tanggal', $today)->sum('total');
        $jumlahLapangan = Lapangan::where('status', '!=', 'nonaktif')->count();
        $transaksiHariIni = Transaksi::whereDate('tanggal', $today)->get();
        $lapangans = Lapangan::where('status', '!=', 'nonaktif')->get();

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

        $jumlahBooking = Transaksi::whereDate('tanggal', $tanggal)->count();
        $totalTransaksi = Transaksi::whereDate('tanggal', $tanggal)->sum('total');
        $transaksiHariIni = Transaksi::whereDate('tanggal', $tanggal)->get();
        $lapangans = Lapangan::where('status', '!=', 'nonaktif')->get();

        $jamMulai = $lapangans->isNotEmpty()
            ? $lapangans->min(fn($lap) => (int) substr($lap->jam_buka, 0, 2))
            : 8;

        $jamSelesai = $lapangans->isNotEmpty()
            ? $lapangans->max(fn($lap) => (int) substr($lap->jam_tutup, 0, 2))
            : 23;

        $jadwal = [];

        for ($i = $jamMulai; $i <= $jamSelesai; $i++) {
            $row = [
                'jam' => sprintf('%02d.00', $i),
                'lapangans' => []
            ];

            foreach ($lapangans as $lap) {
                $row['lapangans'][] = [
                    'nama' => $lap->nama,
                    'booked' => $this->cekStatusBooking($lap, $i, $transaksiHariIni)
                ];
            }

            $jadwal[] = $row;
        }

        return response()->json([
            'jumlahBooking' => $jumlahBooking,
            'totalTransaksi' => 'Rp ' . number_format($totalTransaksi, 0, ',', '.'),
            'jadwal' => $jadwal,
        ]);
    }

    public function booking()
    {
        $lapangans = Lapangan::where('status', '!=', 'nonaktif')->get();

        $transaksi = Transaksi::select('tanggal', 'lapangan', 'jam')
            ->get()
            ->map(function ($trx) {
                return [
                    'tanggal' => Carbon::parse($trx->tanggal)->format('Y-m-d'),
                    'lapangan' => trim($trx->lapangan),
                    'jam' => trim($trx->jam),
                ];
            })
            ->values();

        return view('kasir.booking', compact('lapangans', 'transaksi'));
    }

    public function transaksi(Request $request)
    {
        $query = Transaksi::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('kode_transaksi', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filter == 'hari') {
            $query->whereDate('tanggal', now()->toDateString());
        }

        if ($request->filter == 'bulan') {
            $query->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year);
        }

        if ($request->filter == 'tahun') {
            $query->whereYear('tanggal', now()->year);
        }

        $transaksi = $query->latest()->get();

        return view('kasir.transaksi', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'no_hp'    => 'required|string|max:50',
            'lapangan' => 'required|string',
            'jam'      => 'required|string',
            'durasi'   => 'required',
            'harga'    => 'required',
            'bayar'    => 'required',
            'tanggal'  => 'required|date',
        ]);

        if (Carbon::parse($request->tanggal)->lt(Carbon::today())) {
            return back()->withInput()->with('error', 'Tidak bisa booking untuk tanggal yang sudah lewat!');
        }

        $lapangan = Lapangan::where('nama', $request->lapangan)
            ->where('status', '!=', 'nonaktif')
            ->first();

        if (!$lapangan) {
            return back()->withInput()->with('error', 'Lapangan tidak tersedia atau sedang dinonaktifkan!');
        }

        $harga = (int) str_replace('.', '', $request->harga);
        $bayar = (int) str_replace('.', '', $request->bayar);
        $durasi = (int) $request->durasi;
        $total = $harga * $durasi;
        $kembalian = $bayar - $total;

        if ($bayar < $total) {
            return back()->withInput()->with('error', 'Uang bayar kurang!');
        }

        $jamDipilih = array_map('trim', explode(',', $request->jam));

        $transaksiBentrok = Transaksi::whereDate('tanggal', $request->tanggal)
            ->where('lapangan', $request->lapangan)
            ->get();

        foreach ($transaksiBentrok as $trx) {
            $jamBooked = array_map('trim', explode(',', $trx->jam));

            foreach ($jamDipilih as $jam) {
                if (in_array($jam, $jamBooked)) {
                    return back()->withInput()->with('error', 'Jam ' . $jam . ' sudah dibooking!');
                }
            }
        }

        $kode = 'TRX-' . now()->format('Ymd') . '-' . rand(100, 999);

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
            'kasir'          => Auth::user()->nama,
        ]);

        LogAktivitas::create([
            'id_user' => Auth::id(),
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

        LogAktivitas::create([
            'id_user' => Auth::id(),
            'activity' => 'Mencetak struk transaksi ' . $data->kode_transaksi .
                ' atas nama ' . $data->nama
        ]);

        return view('kasir.struk', compact('data'));
    }

    public function jadwal(Request $request)
    {
        $tanggal = $request->tanggal ?? date('Y-m-d');

        $lapangans = Lapangan::where('status', '!=', 'nonaktif')->get();
        $transaksi = Transaksi::whereDate('tanggal', $tanggal)->get();

        $jamMulai = $lapangans->isNotEmpty()
            ? $lapangans->min(fn($lap) => (int) substr($lap->jam_buka, 0, 2))
            : 8;

        $jamSelesai = $lapangans->isNotEmpty()
            ? $lapangans->max(fn($lap) => (int) substr($lap->jam_tutup, 0, 2))
            : 23;

        $jadwal = [];

        for ($i = $jamMulai; $i <= $jamSelesai; $i++) {
            $row = [
                'jam' => sprintf('%02d.00', $i),
                'lapangans' => []
            ];

            foreach ($lapangans as $lap) {
                $row['lapangans'][] = [
                    'nama' => $lap->nama,
                    'booked' => $this->cekStatusBooking($lap, $i, $transaksi)
                ];
            }

            $jadwal[] = $row;
        }

        return view('kasir.jadwal', compact('jadwal', 'lapangans', 'tanggal'));
    }

    private function cekStatusBooking($lap, $jam, $transaksi)
    {
        $buka = (int) substr(trim($lap->jam_buka), 0, 2);
        $tutup = (int) substr(trim($lap->jam_tutup), 0, 2);

        if ($jam < $buka || $jam > $tutup) {
            return null;
        }

        foreach ($transaksi as $trx) {
            if (trim($trx->lapangan) !== trim($lap->nama)) {
                continue;
            }

            $jamDb = trim($trx->jam);

            foreach (explode(',', $jamDb) as $j) {
                $jamBooking = (int) substr(trim($j), 0, 2);

                if ($jam == $jamBooking) {
                    return $trx->nama;
                }
            }
        }

        return false;
    }
}
