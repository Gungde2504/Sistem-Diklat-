<?php

namespace App\Actions\Event;

use App\DTOs\EventDTO;
use App\Models\MDiklat;

class UpdateEventAction
{
    public function execute(MDiklat $diklat, EventDTO $dto): MDiklat
    {
        $diklat->update([
            'nama'           => $dto->nama,
            'jenisDiklat'    => $dto->jenisDiklat,
            'namaNarasumber' => $dto->namaNarasumber,
            'tempat'         => $dto->tempat,
            'tglJamMulai'    => $dto->tglJamMulai,
            'tglJamSelesai'  => $dto->tglJamSelesai,
            'durasi'         => $dto->durasi,
            'kuota'          => $dto->kuota,
            'deskripsi'      => $dto->deskripsi,
            'linkPretest'    => $dto->linkPretest,
            'linkPosttest'   => $dto->linkPosttest,
            'publish'        => $dto->publish,
            'status'         => $dto->status,
        ]);

        return $diklat->fresh();
    }
}