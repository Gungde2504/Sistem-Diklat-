<?php

namespace App\Enums;

enum StatusPesertaEnum: string
{
    case Aktif      = 'aktif';
    case Selesai    = 'selesai';
    case TidakLanjut = 'tidak_lanjut';
}