<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExternalDailyAttendance extends Model
{
    protected $table = 'external_daily_attendances';

    protected $fillable = [
        'id_user',
        'tanggal',
        'checkin_at',
        'checkout_at',
        'mode',
        'latitude',
        'longitude',
        'is_valid',
        'device_info',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'     => 'date',
            'checkin_at'  => 'datetime',
            'checkout_at' => 'datetime',
            'is_valid'    => 'boolean',
            'latitude'    => 'float',
            'longitude'   => 'float',
        ];
    }

    // ── Scopes ────────────────────────────────────────
    public function scopeValid($query)
    {
        return $query->where('is_valid', 1);
    }

    public function scopeHariIni($query)
    {
        return $query->where('tanggal', today());
    }

    // ── Helpers ───────────────────────────────────────
    public function sudahCheckin(): bool
    {
        return !is_null($this->checkin_at);
    }

    public function sudahCheckout(): bool
    {
        return !is_null($this->checkout_at);
    }

    public function getDurasiAttribute(): ?int
    {
        if (!$this->checkin_at || !$this->checkout_at) return null;
        return (int) $this->checkin_at->diffInMinutes($this->checkout_at);
    }

    // ── Relations ─────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}