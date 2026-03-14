<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    // Nama tabel (opsional, kalau berbeda dari default)
    protected $table = 'laporan';

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'total',
    ];
}
