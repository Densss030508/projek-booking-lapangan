<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'kode_transaksi',
        'tanggal',
        'nama',
        'no_hp',
        'lapangan',
        'jam',
        'durasi',
        'harga',
        'total',
        'bayar',
        'kembalian'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'durasi' => 'integer',
        'harga' => 'integer',
        'total' => 'integer',
        'bayar' => 'integer',
        'kembalian' => 'integer',
    ];
}
