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
        if (!session()->has('admin')) {
            return redirect()->route('admin.form')->withErrors(['email' => 'Vui lòng đăng nhập']);
        }

        $role = session('admin')['role'];

        if (!in_array($role, [1, 4, 3])) {
            return redirect()->route('admin.form')->withErrors(['email' => 'Bạn không có quyền truy cập']);
        }

        return $next($request);
    }
}
