<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForceFromApp
{
    public function handle(Request $request, Closure $next)
    {
        $previous = url()->previous();
        $currentHost = $request->getHost();

        if (!str_contains($previous, $currentHost)) {

            if (Auth::check()) {
                Auth::logout();
            }

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');
        }

        return $next($request);
    }
}
