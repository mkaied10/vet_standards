<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/'); // أو اعمل abort(403) لو مش عايز تعيد التوجيه
        }

        return $next($request);
    }
}
