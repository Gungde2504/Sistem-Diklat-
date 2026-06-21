<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MUnit extends Model
{
    protected $table = 'm_units';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nama',
        'slug',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString();
            }
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });
    }

    // ── Relations ─────────────────────────────────────
    public function pesertaEksternal(): HasMany
    {
        return $this->hasMany(DetailEksternal::class, 'id_unit');
    }

    public function elearningModules(): HasMany
    {
        return $this->hasMany(ElearningModule::class, 'id_target_unit');
    }
}