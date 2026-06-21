<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DetailEksternal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DaftarExternalController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'nama'            => 'required|string|max:100',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:6|same:konfirmasi',
            'hp'              => 'nullable|string|max:20',
            'alamat'          => 'nullable|string|max:255',
            'jenis'           => 'required|string|in:pkl,magang,orientasi',
            'institusi'       => 'required|string|max:200',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ], [
            'email.unique'                  => 'Email sudah terdaftar.',
            'password.same'                 => 'Konfirmasi password tidak cocok.',
            'password.min'                  => 'Password minimal 6 karakter.',
            'jenis.in'                      => 'Pilih jenis yang valid.',
            'tanggal_mulai.required'        => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required'      => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after_or_equal'=> 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

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
            'institusi'       => $request->institusi,
            'id_unit'         => $request->id_unit ?: null,
            'id_supervisor'   => $request->id_supervisor ?: null,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status'          => 'aktif',
            'approval_status' => 'pending',
            'created_by'      => 1,
        ]);

        return redirect()->route('daftar.external.sukses');
    }
}