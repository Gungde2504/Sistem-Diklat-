<?php

namespace App\Actions\Event;

use App\DTOs\EventDTO;
use App\Helpers\QrHelper;
use App\Models\MDiklat;

class CreateEventAction
{
    public function execute(EventDTO $dto): MDiklat
    {
        return MDiklat::create([
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
            'img'            => $dto->img,
            'QRcode'         => QrHelper::generateToken(),
            'IsActive'       => 0,
        ]);
    }
}