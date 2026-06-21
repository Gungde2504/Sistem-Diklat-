<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailEksternal;

class AuthHelper
{
    public static function redirectByRole(): string
    {
        $user = Auth::user();
        if (!$user) return '/login';

        if ($user->role === 'peserta_eksternal') {
            $detail = DetailEksternal::where('id_user', $user->id)->first();
            if ($detail && DetailEksternal::isKaryawanExternal($detail->jenis)) {
                return route('pegawai.dashboard'); // karyawan external → dashboard pegawai
            }
            return route('eksternal.dashboard');
        }

        return match($user->role) {
            'super_admin', 'admin_diklat' => route('admin.dashboard'),
            'pegawai'                     => route('pegawai.dashboard'),
            default                       => '/login',
        };
    }

    public static function checkRole(string|array $roles): bool
    {
        $user = Auth::user();
        if (!$user) return false;
        $roles = is_array($roles) ? $roles : [$roles];
        return in_array($user->role, $roles);
    }

    public static function isAdmin(): bool
    {
        return self::checkRole(['super_admin', 'admin_diklat']);
    }
}