<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $table = 'lapangans';

    protected $fillable = [
        'nama',
        'status',
        'harga',
        'foto',
        'jam_buka',
        'jam_tutup'
    ];

    public $timestamps = true;
}
