<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next)
    {
        if (!session()->has('admin') || session('admin')['role_id'] != 1) {
            return redirect()->route('admin.form')->withErrors(['email' => 'Vui lòng đăng nhập admin']);
        }

        return $next($request);
    }
}
