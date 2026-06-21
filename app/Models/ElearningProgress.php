<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElearningProgress extends Model
{
    protected $table = 'elearning_progress';

    protected $fillable = [
        'id_user',
        'id_modul',
        'started_at',
        'completed_at',
        'quiz_score',
        'status',
        'jam_dikontribusikan',
    ];

    protected function casts(): array
    {
        return [
            'started_at'          => 'datetime',
            'completed_at'        => 'datetime',
            'quiz_score'          => 'float',
            'jam_dikontribusikan' => 'float',
        ];
    }

    // ── Scopes ────────────────────────────────────────
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    // ── Helpers ───────────────────────────────────────
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    // ── Relations ─────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function modul(): BelongsTo
    {
        return $this->belongsTo(ElearningModule::class, 'id_modul');
    }
}