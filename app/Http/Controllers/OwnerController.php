<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Lapangan;
use App\Models\LogAktivitas;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();
        $now   = Carbon::now();

        $totalTransaksiHariIni = Transaksi::whereDate('tanggal', $today)->count();
        $pendapatanHariIni     = Transaksi::whereDate('tanggal', $today)->sum('total');

        $pendapatanBulanIni = (int) Transaksi::whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->sum('total');

        $totalLapangan = Lapangan::where('status', '!=', 'nonaktif')->count();

        $mingguan = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl   = Carbon::today()->subDays($i);
            $label = $tgl->format('d/m');

            $mingguan[] = [
                'label'  => $label,
                'jumlah' => Transaksi::whereDate('tanggal', $tgl)->count(),
            ];
        }

        return view('owner.dashboard', compact(
            'totalTransaksiHariIni',
            'pendapatanHariIni',
            'pendapatanBulanIni',
            'totalLapangan',
            'mingguan'
        ));
    }

    public function produk(Request $request)
    {
        $query = Lapangan::query();

        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%');
        }

        $lapangans = $query->get();

        return view('owner.produk', compact('lapangans'));
    }

    public function detail($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('owner.detail', compact('lapangan'));
    }

    public function laporan(Request $request)
    {
        $dari     = $request->dari;
        $sampai   = $request->sampai;
        $lapangan = $request->lapangan;

        $query = Transaksi::query();

        if ($dari && $sampai) {
            $query->whereBetween('tanggal', [$dari, $sampai]);
        }

        if ($lapangan) {
            $query->where('lapangan', $lapangan);
        }

        $transaksi = $query->orderBy('tanggal')->get();
        $lapangans = Lapangan::all();

        $totalPendapatan = $transaksi->sum('total');
        $totalTransaksi  = $transaksi->count();
        $rataRata        = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        $lapanganTerlaris = $transaksi
            ->groupBy('lapangan')
            ->map->count()
            ->sortDesc()
            ->keys()
            ->first();

        return view('owner.laporan', compact(
            'transaksi',
            'lapangans',
            'dari',
            'sampai',
            'lapangan',
            'totalPendapatan',
            'totalTransaksi',
            'rataRata',
            'lapanganTerlaris'
        ));
    }

    public function exportExcel(Request $request)
    {
        $dari     = $request->dari;
        $sampai   = $request->sampai;
        $lapangan = $request->lapangan;
        $nama     = 'laporan_' . ($dari ?? 'semua') . '_' . ($sampai ?? 'semua') . '.xlsx';

        return Excel::download(new LaporanExport($dari, $sampai, $lapangan), $nama);
    }

    public function exportPdf(Request $request)
    {
        $dari     = $request->dari;
        $sampai   = $request->sampai;
        $lapangan = $request->lapangan;

        $query = Transaksi::query();

        if ($dari && $sampai) {
            $query->whereBetween('tanggal', [$dari, $sampai]);
        }

        if ($lapangan) {
            $query->where('lapangan', $lapangan);
        }

        $transaksi = $query->orderBy('tanggal')->get();

        $html = view('owner.laporan_pdf', compact(
            'transaksi',
            'dari',
            'sampai',
            'lapangan'
        ))->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $nama = 'laporan_' . ($dari ?? 'semua') . '_' . ($sampai ?? 'semua') . '.pdf';

        return response($dompdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $nama . '"',
        ]);
    }

    public function aktivitas(Request $request)
    {
        $query = LogAktivitas::with('user')->latest('id');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('activity', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($user) use ($search) {
                        $user->where('nama', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('role', $request->role);
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $logs = $query->get();

        $totalLogs = LogAktivitas::count();

        $totalAdmin = LogAktivitas::whereHas('user', fn($q) => $q->where('role', 'admin'))->count();
        $totalKasir = LogAktivitas::whereHas('user', fn($q) => $q->where('role', 'kasir'))->count();
        $totalOwner = LogAktivitas::whereHas('user', fn($q) => $q->where('role', 'owner'))->count();

        return response()->view('owner.aktivitas', compact(
            'logs',
            'totalLogs',
            'totalAdmin',
            'totalKasir',
            'totalOwner'
        ))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
