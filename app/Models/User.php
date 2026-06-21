<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'type',
        'role',
        'name',
        'nip',
        'nama',
        'email',
        'password',
        'hp',
        'alamat',
        'unit',
        'profesi',
        'jabatan',
        'hp',
        'isActive',
        'notif_last_read_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'  => 'datetime',
            'password'           => 'hashed',
            'isActive'           => 'boolean',
            'notif_last_read_at' => 'datetime',
        ];
    }

    // ── Scopes ────────────────────────────────────────
    public function scopeInternal($query)
    {
        return $query->where('type', 'internal');
    }

    public function scopeExternal($query)
    {
        return $query->where('type', 'external');
    }

    public function scopeAktif($query)
    {
        return $query->where('isActive', 1);
    }

    // ── Helpers ───────────────────────────────────────
    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin_diklat']);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isPegawai(): bool
    {
        return $this->role === 'pegawai';
    }

    public function isEksternal(): bool
    {
        return $this->type === 'external';
    }

    // ── Relations ─────────────────────────────────────
    public function detailEksternal(): HasOne
    {
        return $this->hasOne(DetailEksternal::class, 'id_user');
    }

    public function absensiDiklats(): HasMany
    {
        return $this->hasMany(RecordAbsensiDiklat::class, 'id_user');
    }

    public function diklatMandiris(): HasMany
    {
        return $this->hasMany(DiklatMandiri::class, 'id_user');
    }

    public function absensiHarian(): HasMany
    {
        return $this->hasMany(ExternalDailyAttendance::class, 'id_user');
    }

    public function elearningProgress(): HasMany
    {
        return $this->hasMany(ElearningProgress::class, 'id_user');
    }
}
