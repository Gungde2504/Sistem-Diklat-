<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MFileDiklat extends Model
{
    protected $table = 'm_file_diklats';

    protected $fillable = [
        'id_diklat',
        'file',
        'type',
        'nomor_sertifikat',
        'created_by',
    ];

    // ── Relations ─────────────────────────────────────
    public function diklat(): BelongsTo
    {
        return $this->belongsTo(MDiklat::class, 'id_diklat');
    }
}
