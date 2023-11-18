<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Users;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        $user = session('user');

        // Kiểm tra xem người dùng đã đăng nhập và có role phù hợp không
        if ($user && ($user->RoleID == $role || $user->RoleID == 1)) {
            return $next($request);
        }

        // Người dùng chưa đăng nhập hoặc có role không phù hợp, chuyển hướng đến trang đăng nhập
        return redirect()->route('login');
    }
}
