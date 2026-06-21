<?php

namespace App\Actions\Absensi;

use App\DTOs\AbsensiDTO;
use App\Models\MDiklat;
use App\Models\RecordAbsensiDiklat;
use Illuminate\Support\Facades\Auth;

class ScanQrAction
{
    public function execute(string $token): array
    {
        // 1. Cari acara berdasarkan token QR
        $diklat = MDiklat::where('QRcode', $token)->first();

        if (!$diklat) {
            return ['success' => false, 'message' => 'QR Code tidak valid.'];
        }

        // 2. Validasi QR aktif
        if (!$diklat->IsActive) {
            return ['success' => false, 'message' => 'QR Code tidak aktif.'];
        }

        $user = Auth::user();

        // 3. Cek duplikasi
        $sudahAbsen = RecordAbsensiDiklat::where('id_user', $user->id)
            ->where('id_diklat', $diklat->id)
            ->exists();

        if ($sudahAbsen) {
            return ['success' => false, 'message' => 'Anda sudah melakukan absensi untuk acara ini.'];
        }

        // 4. Catat kehadiran
        $dto = new AbsensiDTO(
            idUser:      $user->id,
            idDiklat:    $diklat->id,
            namaPeserta: $user->nama,
            durasi:      (int) $diklat->durasi * 60, // jam ke menit
            date:        now()->toDateString(),
        );

        RecordAbsensiDiklat::create([
            'id_user'     => $dto->idUser,
            'id_diklat'   => $dto->idDiklat,
            'namaPeserta' => $dto->namaPeserta,
            'durasi'      => $dto->durasi,
            'date'        => $dto->date,
        ]);

        return [
            'success' => true,
            'message' => "Absensi berhasil dicatat untuk acara: {$diklat->nama}",
        ];
    }
}