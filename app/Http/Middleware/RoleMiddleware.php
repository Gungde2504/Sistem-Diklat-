<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\DetailEksternal;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Karyawan external boleh akses route pegawai
        if (in_array('pegawai', $roles) && $user->role === 'peserta_eksternal') {
            $detail = DetailEksternal::where('id_user', $user->id)->first();
            if ($detail && DetailEksternal::isKaryawanExternal($detail->jenis)) {
                return $next($request);
            }
        }

        if (!in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}