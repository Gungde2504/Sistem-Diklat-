<?php

namespace App\DTOs;

class AbsensiDTO
{
    public function __construct(
        public readonly int     $idUser,
        public readonly int     $idDiklat,
        public readonly string  $namaPeserta,
        public readonly int     $durasi,
        public readonly string  $date,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            idUser:      $data['id_user'],
            idDiklat:    $data['id_diklat'],
            namaPeserta: $data['namaPeserta'],
            durasi:      (int) $data['durasi'],
            date:        $data['date'],
        );
    }
}