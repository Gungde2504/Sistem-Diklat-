<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        'kategori',
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


    /**
     * Daftarkan peserta secara atomik (kunci baris acara) supaya kuota tidak terlampaui
     * walaupun beberapa peserta menekan "Daftar" bersamaan.
     * @return string 'ok' | 'penuh' | 'sudah'
     */
    public function daftarkanPeserta(\App\Models\User $user, array $extra = []): string
    {
        return DB::transaction(function () use ($user, $extra) {
            $acara = static::whereKey($this->id)->lockForUpdate()->first();

            $sudah = RecordAbsensiDiklat::where('id_user', $user->id)
                ->where('id_diklat', $acara->id)->exists();
            if ($sudah) return 'sudah';

            if ($acara->sudahPenuh()) return 'penuh';

            RecordAbsensiDiklat::create(array_merge([
                'id_user'     => $user->id,
                'id_diklat'   => $acara->id,
                'namaPeserta' => $user->nama,
                'durasi'      => 0,
                'date'        => now()->toDateString(),
                'is_hadir'    => false,
            ], $extra));

            return 'ok';
        });
    }

    public function pesanPenuh(): string
    {
        return 'Maaf, kuota peserta acara ini sudah penuh ('.$this->kuota.'/'.$this->kuota.'). Pendaftaran sudah ditutup dan Anda tidak dapat mendaftar.';
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

    /**
     * Unit-unit yang boleh mengikuti acara ini.
     */
    public function units(): BelongsToMany
    {
        return $this->belongsToMany(MUnit::class, 'm_diklat_unit', 'id_diklat', 'id_unit');
    }

    public function kategoriLabel(): string
    {
        return match ($this->kategori) {
            'medis'     => 'Medis',
            'non_medis' => 'Non Medis',
            default     => '-',
        };
    }
}
