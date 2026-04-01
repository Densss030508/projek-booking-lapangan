<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log';

    public $timestamps = false;

    protected $fillable = ['id_user', 'activity'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
