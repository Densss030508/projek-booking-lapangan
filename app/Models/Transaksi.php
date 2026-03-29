<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transactions'; // 🔥 FIX

    protected $fillable = [
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
}
