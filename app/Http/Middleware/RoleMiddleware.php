<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {

        // Kiểm tra đã đăng nhập chưa
        if(!Auth::check())
        {
            return redirect()
            ->route('admin.login');
        }


        // Kiểm tra quyền
        if(!in_array(Auth::user()->role, $roles))
        {
            abort(403, "Bạn không có quyền truy cập.");
        }


        return $next($request);
    }
}