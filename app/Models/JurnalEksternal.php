<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JurnalEksternal extends Model
{
    protected $table = 'jurnal_eksternals';

    protected $fillable = [
        'id_user',
        'tanggal',
        'aktivitas',
        'kendala',
        'rencana_besok',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function bisaDiedit(): bool
    {
        // Bisa diedit dalam 24 jam setelah dibuat
        return $this->created_at->diffInHours(now()) <= 24;
    }
}