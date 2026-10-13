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

    /**
     * Unit resmi (daftar MUnitSeeder) untuk pilihan "Unit yang Dapat Mengikuti".
     * $sertakanId: id unit lain yang tetap ikut ditampilkan (mis. yang sudah
     * terpilih di acara lama), supaya tidak hilang saat acara diedit.
     */
    public static function pilihanAcara(array $sertakanId = [])
    {
        $slugResmi = array_map(fn ($n) => Str::slug($n), \Database\Seeders\MUnitSeeder::semua());

        return static::query()
            ->where(function ($q) use ($slugResmi, $sertakanId) {
                $q->whereIn('slug', $slugResmi);
                if (!empty($sertakanId)) {
                    $q->orWhereIn('id', $sertakanId);
                }
            })
            ->orderBy('nama')
            ->get();
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