<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role_id): Response
    {
        if (Auth::user()->role_id == $role_id) {
            return $next($request);
        }
        if (Auth::user()->role_id == 1) {
            return redirect('admin/dashboard');
        } elseif (Auth::user()->role_id == 2) {
            return redirect('user/dashboard');
        } elseif (Auth::user()->role_id == 3) {
            return redirect('sarpras/dashboard');
        } elseif (Auth::user()->role_id == 4) {
            return redirect('perencanaan/dashboard');
        } elseif (Auth::user()->role_id == 5) {
            return redirect('pengadaan/dashboard');
        } else {
            return redirect('wakilRektor2/dashboard');
        }
    }
}
