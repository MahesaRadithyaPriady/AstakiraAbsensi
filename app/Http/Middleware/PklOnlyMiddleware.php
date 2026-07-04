<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PklOnlyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->isPkl()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk PKL.');
        }

        return $next($request);
    }
}
