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
            $q->whereNull('id_target_unit')
              ->orWhere('id_target_unit', $unitSlug);
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