<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LogAktivitas extends Model
{
    protected $table = 'log';

    public $timestamps = true;
    const UPDATED_AT = null;

    protected $fillable = [
        'id_user',
        'activity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
