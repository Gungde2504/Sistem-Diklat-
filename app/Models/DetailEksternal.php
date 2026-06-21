<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailEksternal extends Model
{
    protected $table = 'detail_eksternals';

    protected $fillable = [
        'id_user',
        'jenis',
        'institusi',
        'vendor',
        'id_unit',
        'id_supervisor',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'approval_status',
        'approval_note',
        'approved_by',
        'approved_at',
        'cert_qr_token',
        'cert_file_path',
        'cert_back_path',
        'nilai_akhir',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'date',
            'tanggal_selesai' => 'date',
            'approved_at'     => 'datetime',
        ];
    }

    // Jenis options
    public static function jenisOptions(): array
    {
        return [
            'pkl'                  => 'PKL',
            'magang'               => 'Magang',
            'orientasi'            => 'Orientasi',
            'karyawan_iss'         => 'Karyawan ISS',
            'karyawan_bss'         => 'Karyawan BSS',
            'karyawan_adidaya'     => 'Karyawan PT. Adidaya',
            'karyawan_bayi_tabung' => 'Karyawan Bayi Tabung',
            'karyawan_koperasi'    => 'Karyawan Koperasi',
            'karyawan_lotus_spa'   => 'Karyawan Lotus SPA',
        ];
    }

    public static function isKaryawanExternal(string $jenis): bool
    {
        return str_starts_with($jenis, 'karyawan_');
    }

    // Status otomatis berdasarkan tanggal
    public function hitungStatus(): string
    {
        if ($this->approval_status !== 'approved') return $this->status;
        if (!$this->tanggal_mulai || !$this->tanggal_selesai) return 'aktif';

        $now = now()->toDateString();

        if ($now < $this->tanggal_mulai->toDateString()) return 'aktif';
        if ($now <= $this->tanggal_selesai->toDateString()) return 'aktif';

        return 'selesai';
    }

    public function updateStatusOtomatis(): void
    {
        if ($this->tanggal_selesai && now()->gt($this->tanggal_selesai)) {
            $this->update(['status' => 'selesai']);
        }
    }

    // Scopes
    public function scopeAktif($query)       { return $query->where('status', 'aktif'); }
    public function scopeSelesai($query)     { return $query->where('status', 'selesai'); }
    public function scopeApproved($query)    { return $query->where('approval_status', 'approved'); }
    public function scopePending($query)     { return $query->where('approval_status', 'pending'); }
    public function scopeByJenis($query, string $jenis) { return $query->where('jenis', $jenis); }

    // Helpers
    public function sudahGenerateSertifikat(): bool { return !empty($this->cert_file_path); }
    public function bisaGenerateSertifikat(): bool
    {
        return $this->status === 'selesai'
            && in_array($this->jenis, ['pkl', 'magang']);
    }
    public function sisaHari(): int
    {
        if (!$this->tanggal_selesai) return 0;
        return max(0, now()->diffInDays($this->tanggal_selesai, false));
    }
    public function isPending(): bool   { return $this->approval_status === 'pending'; }
    public function isApproved(): bool  { return $this->approval_status === 'approved'; }
    public function isRejected(): bool  { return $this->approval_status === 'rejected'; }
    public function isKaryawan(): bool  { return self::isKaryawanExternal($this->jenis); }

    // Relations
    public function user(): BelongsTo      { return $this->belongsTo(User::class, 'id_user'); }
    public function unit(): BelongsTo      { return $this->belongsTo(MUnit::class, 'id_unit'); }
    public function supervisor(): BelongsTo { return $this->belongsTo(User::class, 'id_supervisor'); }
    public function createdBy(): BelongsTo  { return $this->belongsTo(User::class, 'created_by'); }
    public function approvedBy(): BelongsTo { return $this->belongsTo(User::class, 'approved_by'); }
    public function absensiHarian(): HasMany
    {
        return $this->hasMany(ExternalDailyAttendance::class, 'id_user', 'id_user');
    }
}