<?php

namespace App\Enums;

enum RoleEnum: string
{
    case SuperAdmin      = 'super_admin';
    case AdminDiklat     = 'admin_diklat';
    case Pegawai         = 'pegawai';
    case PesertaEksternal = 'peserta_eksternal';
}