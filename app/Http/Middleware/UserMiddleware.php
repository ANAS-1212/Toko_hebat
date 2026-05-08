<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || $request->user()->role !== 'user') {
            return ResponseHelper::error('Akses ditolak. Hanya untuk user biasa.', 400);
        }

        return $next($request);
    }
}