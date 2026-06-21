<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DetailEksternal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DaftarKaryawanExternalController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|same:konfirmasi',
            'hp'       => 'nullable|string|max:20',
            'alamat'   => 'nullable|string|max:255',
            'jenis'    => 'required|string|in:karyawan_iss,karyawan_bss,karyawan_adidaya,karyawan_bayi_tabung,karyawan_koperasi,karyawan_lotus_spa',
        ], [
            'email.unique'   => 'Email sudah terdaftar.',
            'password.same'  => 'Konfirmasi password tidak cocok.',
            'password.min'   => 'Password minimal 6 karakter.',
            'jenis.required' => 'Pilih vendor terlebih dahulu.',
            'jenis.in'       => 'Pilih vendor yang valid.',
        ]);

        // Label vendor otomatis dari jenis
        $jenisLabel = [
            'karyawan_iss'         => 'ISS',
            'karyawan_bss'         => 'BSS',
            'karyawan_adidaya'     => 'PT. Adidaya',
            'karyawan_bayi_tabung' => 'Bayi Tabung',
            'karyawan_koperasi'    => 'Koperasi',
            'karyawan_lotus_spa'   => 'Lotus SPA',
        ];

        $user = User::create([
            'name'     => $request->nama,
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'hp'       => $request->hp,
            'alamat'   => $request->alamat,
            'type'     => 'external',
            'role'     => 'peserta_eksternal',
            'isActive' => false,
        ]);

        DetailEksternal::create([
            'id_user'         => $user->id,
            'jenis'           => $request->jenis,
            'institusi'       => $jenisLabel[$request->jenis] ?? $request->jenis,
            'id_unit'         => null,
            'id_supervisor'   => null,
            'tanggal_mulai'   => null,
            'tanggal_selesai' => null,
            'status'          => 'aktif',
            'approval_status' => 'pending',
            'created_by'      => 1,
        ]);

        return redirect()->route('daftar.external.sukses');
    }
}