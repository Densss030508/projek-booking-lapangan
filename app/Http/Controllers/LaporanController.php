<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // Misalnya ambil data dari database
        // $laporan = ModelLaporan::all();

        return view('admin.laporan.index'); // kirim data ke view jika perlu
    }
}
