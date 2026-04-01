<?php

namespace App\Helpers;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function catat($aktivitas)
    {
        if (Auth::check()) {
            LogAktivitas::create([
                'id_user'  => Auth::id(),
                'activity' => $aktivitas,
            ]);
        }
    }
}
