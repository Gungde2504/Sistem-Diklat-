<?php

namespace App\DTOs;

class EventDTO
{
    public function __construct(
        public readonly string  $nama,
        public readonly string  $jenisDiklat,
        public readonly string  $namaNarasumber,
        public readonly string  $tempat,
        public readonly string  $tglJamMulai,
        public readonly string  $tglJamSelesai,
        public readonly int     $durasi,
        public readonly int     $kuota,
        public readonly ?string $deskripsi    = null,
        public readonly ?string $linkPretest  = null,
        public readonly ?string $linkPosttest = null,
        public readonly int     $publish      = 0,
        public readonly string  $status       = 'Draft',
        public readonly ?string $img          = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nama:           $data['nama'],
            jenisDiklat:    $data['jenisDiklat'],
            namaNarasumber: $data['namaNarasumber'],
            tempat:         $data['tempat'],
            tglJamMulai:    $data['tglJamMulai'],
            tglJamSelesai:  $data['tglJamSelesai'],
            durasi:         (int) $data['durasi'],
            kuota:          (int) $data['kuota'],
            deskripsi:      $data['deskripsi']    ?? null,
            linkPretest:    $data['linkPretest']  ?? null,
            linkPosttest:   $data['linkPosttest'] ?? null,
            publish:        (int) ($data['publish'] ?? 0),
            status:         $data['status']       ?? 'Draft',
            img:            $data['img']          ?? null,
        );
    }
}