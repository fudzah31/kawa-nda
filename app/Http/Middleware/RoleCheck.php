<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek kalau belum login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil role user dari database
        $userRole = strtolower((string) Auth::user()->role);

        // Normalisasi roles
        $allowed = [];
        foreach ($roles as $role) {
            $parts = explode(',', $role);
            foreach ($parts as $part) {
                $allowed[] = strtolower(trim($part));
            }
        }

        // Cek role
        if (!in_array($userRole, $allowed)) {
            abort(403, 'Akses ditolak!');
        }

        return $next($request);
    }
}
