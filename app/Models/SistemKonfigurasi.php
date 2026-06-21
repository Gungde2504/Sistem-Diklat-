<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SistemKonfigurasi extends Model
{
    protected $table    = 'sistem_konfigurasi';
    protected $fillable = ['key', 'value', 'label', 'group'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $record = static::where('key', $key)->first();
        return $record ? $record->value : $default;
    }

    public static function set(string $key, mixed $value): bool
    {
        $result = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        return $result !== null;
    }
}
