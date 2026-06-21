<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecordAbsensiDiklat extends Model
{
    protected $table = 'record_absensi_diklats';

    protected $fillable = [
        'id_user',
        'id_diklat',
        'namaPeserta',
        'durasi',
        'date',
        'is_hadir',
    ];

    protected function casts(): array
    {
        return [
            'date'     => 'date',
            'durasi'   => 'integer',
            'is_hadir' => 'boolean',
        ];
    }

    // ── Helpers ───────────────────────────────────────
    public function getJamAttribute(): float
    {
        return round($this->durasi / 60, 2);
    }

    // ── Relations ─────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function diklat(): BelongsTo
    {
        return $this->belongsTo(MDiklat::class, 'id_diklat');
    }
}