<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
       
        if (!$request->user() || $request->user()->role !== 'admin') {
            return ResponseHelper::error('Akses ditolak. Hanya untuk admin.', 403);
        }

        return $next($request);
    }
}