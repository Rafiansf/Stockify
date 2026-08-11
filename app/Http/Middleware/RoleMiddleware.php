<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = strtolower(Auth::user()->role);

        // Menampung dan memisahkan role jika dipisah koma atau dikirim sebagai variadic
        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode(',', strtolower($role)));
        }

        // Khusus jika role pengguna adalah 'manager', samakan dengan 'manager_gudang'
        if ($userRole === 'manager') {
            $userRole = 'manager_gudang';
        }

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}