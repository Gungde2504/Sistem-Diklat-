<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MDiklat extends Model
{
    use SoftDeletes;

    protected $table = 'm_diklats';

    protected $fillable = [
        'img',
        'nama',
        'deskripsi',
        'namaNarasumber',
        'jenisDiklat',
        'tglJamMulai',
        'tglJamSelesai',
        'tempat',
        'durasi',
        'kuota',
        'publish',
        'slug',
        'status',
        'linkPretest',
        'linkPosttest',
        'QRcode',
        'IsActive',
    ];

    protected function casts(): array
    {
        return [
            'publish'  => 'boolean',
            'IsActive' => 'boolean',
            'kuota'    => 'integer',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama) . '-' . Str::random(5);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('publish', 1);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeQrAktif($query)
    {
        return $query->where('IsActive', 1);
    }

    public function isQrAktif(): bool
    {
        return (bool) $this->IsActive;
    }

    public function sisaKuota(): int
    {
        return max(0, $this->kuota - $this->absensiDiklats()->count());
    }

    public function sudahPenuh(): bool
    {
        return $this->sisaKuota() <= 0;
    }

    public function absensiDiklats(): HasMany
    {
        return $this->hasMany(RecordAbsensiDiklat::class, 'id_diklat');
    }

    public function files(): HasMany
    {
        return $this->hasMany(MFileDiklat::class, 'id_diklat');
    }

    public function fotoDokumentasi(): HasMany
    {
        return $this->files()->where('type', 'foto');
    }

    public function materiFiles(): HasMany
    {
        return $this->files()->where('type', 'materi');
    }

    public function templateSertifikat(): HasMany
    {
        return $this->files()->where('type', 'sertifikat');
    }
}