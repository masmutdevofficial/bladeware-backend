<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user belum login
        if (!Auth::check()) {
            // Pastikan user tidak diarahkan ke halaman login secara terus-menerus
            if ($request->is('login')) {
                return $next($request);
            }
            return redirect()->route('admin.login')->with('error', 'Please login first!');
        }

        return $next($request);
    }
}
