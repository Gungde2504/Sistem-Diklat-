<?php

namespace App\Enums;

enum StatusEnum: string
{
    case Draft       = 'Draft';
    case Terbuka     = 'Terbuka';
    case Berlangsung = 'Berlangsung';
    case Selesai     = 'Selesai';
}