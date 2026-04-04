<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAktivitas;

class LogActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user');

        if ($request->filled('search')) {
            $query->where('activity', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('nama', 'like', '%' . $request->search . '%');
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

        $logs = $query->orderBy('created_at', 'desc')->paginate(10);

        $totalLogs = LogAktivitas::count();
        $totalAdmin = LogAktivitas::whereHas('user', function ($q) {
            $q->where('role', 'admin');
        })->count();
        $totalKasir = LogAktivitas::whereHas('user', function ($q) {
            $q->where('role', 'kasir');
        })->count();
        $totalOwner = LogAktivitas::whereHas('user', function ($q) {
            $q->where('role', 'owner');
        })->count();

        return view('owner.log-activity', compact('logs', 'totalLogs', 'totalAdmin', 'totalKasir', 'totalOwner'));
    }
}
