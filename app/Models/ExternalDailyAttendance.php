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

    // Catatan menyimpan fakta validitas yang DIBEKUKAN pada saat check-in/
    // check-out terjadi (lihat AbsensiHarian::checkin()/checkout()), supaya
    // tidak ikut berubah kalau config lokasi RS diubah admin belakangan.
    // Data sistem ini ditaruh di bawah key "_meta" supaya kalau nanti ada
    // fitur catatan manual (mis. key "pesan"), keduanya tidak saling timpa.
    private function catatanMeta(): array
    {
        $catatan = json_decode($this->catatan ?? '', true) ?: [];
        return $catatan['_meta'] ?? [];
    }

    // Catatan manual (human-written), kalau suatu saat fitur itu dibangun.
    public function getCatatanManualAttribute(): ?string
    {
        $catatan = json_decode($this->catatan ?? '', true) ?: [];
        return $catatan['pesan'] ?? null;
    }

    // Validitas check-in: utamakan nilai yang sudah dibekukan di catatan.
    // Kalau tidak ada (data lama sebelum fitur ini dipasang), baru fallback
    // ke hitung ulang dari koordinat tersimpan — koordinat di latitude/
    // longitude memang milik check-in, tidak pernah ditimpa check-out.
    public function isCheckinValid(float $rsLat, float $rsLng, float $rsRadius): bool
    {
        $meta = $this->catatanMeta();
        if (array_key_exists('checkin_valid', $meta)) {
            return (bool) $meta['checkin_valid'];
        }

        if (is_null($this->latitude) || is_null($this->longitude)) {
            return false;
        }

        return \App\Helpers\GeoHelper::isWithinRadius(
            (float) $this->latitude,
            (float) $this->longitude,
            $rsLat,
            $rsLng,
            $rsRadius
        );
    }

    // Validitas check-out: utamakan nilai yang sudah dibekukan di catatan.
    // Kalau tidak ada (data lama), baru DISIMPULKAN secara logis dari
    // is_valid gabungan + check-in yang dihitung ulang:
    //   - belum checkout            -> null (belum ada datanya)
    //   - is_valid keseluruhan true -> true  (checkin & checkout pasti valid)
    //   - is_valid false, tapi checkin terbukti valid -> false (pasti checkout yang invalid)
    //   - is_valid false, checkin juga terbukti invalid -> null (checkout tidak bisa dipastikan)
    public function isCheckoutValid(float $rsLat, float $rsLng, float $rsRadius): ?bool
    {
        if (!$this->checkout_at) {
            return null;
        }

        $meta = $this->catatanMeta();
        if (array_key_exists('checkout_valid', $meta)) {
            return (bool) $meta['checkout_valid'];
        }

        if ($this->is_valid) {
            return true;
        }

        return $this->isCheckinValid($rsLat, $rsLng, $rsRadius) ? false : null;
    }

    // ── Relations ─────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}