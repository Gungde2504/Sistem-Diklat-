<?php

namespace App\Http\Controllers\Eksternal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'hp'   => 'nullable|string|max:20',
        ]);

        auth()->user()->update([
            'nama' => $request->nama,
            'hp'   => $request->hp,
        ]);

        return back()->with('success', 'Profil berhasil disimpan.');
    }

    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ], [
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok.',
            'password_baru.min'       => 'Password baru minimal 8 karakter.',
        ]);

        if (!Hash::check($request->password_lama, auth()->user()->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        auth()->user()->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}