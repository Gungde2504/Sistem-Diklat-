<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiklatMandiri extends Model
{
    use HasUuids;

    protected $table = 'diklat_mandiris';

    protected $fillable = [
        'nama',
        'jenisDiklat',
        'tglJamMulai',
        'tglJamSelesai',
        'tempat',
        'durasi',
        'sertifikat',
        'materi',
        'id_user',
        'status',
    ];

    // ── Scopes ────────────────────────────────────────
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'Disetujui');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'Ditolak');
    }

    // ── Helpers ───────────────────────────────────────
    public function getJamAttribute(): float
    {
        return round((int) $this->durasi / 60, 2);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    // ── Relations ─────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}