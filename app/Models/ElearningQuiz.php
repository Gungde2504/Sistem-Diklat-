<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElearningQuiz extends Model
{
    protected $table = 'elearning_quizzes';

    protected $fillable = [
        'id_modul',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'jawaban_benar',
    ];

    public function modul(): BelongsTo
    {
        return $this->belongsTo(ElearningModule::class, 'id_modul');
    }
}