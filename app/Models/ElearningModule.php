<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ElearningModule extends Model
{
    use SoftDeletes;

    protected $table = 'elearning_modules';

        /** Nama file di storage: prefix acak + nama asli PDF agar nama asli tetap terbaca. */
    public static function namaFileUnik(string $namaAsli): string
    {
        $ext  = pathinfo($namaAsli, PATHINFO_EXTENSION);
        $base = pathinfo($namaAsli, PATHINFO_FILENAME);
        $base = trim(preg_replace('/[^A-Za-z0-9._ \-()]/', '', $base)) ?: 'materi';
        return \Illuminate\Support\Str::random(8) . '__' . $base . ($ext ? '.' . strtolower($ext) : '');
    }

    /** Nama file untuk ditampilkan (tanpa prefix acak). */
    public function getNamaFileAttribute(): ?string
    {
        if (!$this->file_path) return null;
        $b = basename($this->file_path);
        return str_contains($b, '__') ? substr($b, strpos($b, '__') + 2) : $b;
    }

    protected $fillable = [
        'judul',
        'deskripsi',
        'konten',
        'kategori',
        'file_path',
        'link_video',
        'estimasi_durasi_jam',
        'min_quiz_score',
        'id_target_unit',
        'publish',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'publish'             => 'boolean',
            'estimasi_durasi_jam' => 'float',
            'min_quiz_score'      => 'float',
        ];
    }

    // ── Scopes ────────────────────────────────────────
    public function scopePublished($query)
    {
        return $query->where('publish', 1);
    }

    public function scopeForUnit($query, ?string $unitSlug)
    {
        return $query->where(function ($q) use ($unitSlug) {
            $q->whereNull('id_target_unit');

            // id_target_unit menyimpan UUID m_units.id, sedangkan $unitSlug
            // (dari User->unit) adalah m_units.slug — jadi dicocokkan lewat
            // relasi targetUnit, bukan dibandingkan langsung.
            if ($unitSlug) {
                $q->orWhereHas('targetUnit', fn($uq) => $uq->where('slug', $unitSlug));
            }
        });
    }

    // ── Helpers ───────────────────────────────────────
    public function adaKuis(): bool
    {
        return !is_null($this->min_quiz_score);
    }

    // ── Relations ─────────────────────────────────────
    public function targetUnit(): BelongsTo
    {
        return $this->belongsTo(MUnit::class, 'id_target_unit');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(ElearningQuiz::class, 'id_modul');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(ElearningProgress::class, 'id_modul');
    }
}