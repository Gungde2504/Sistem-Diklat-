<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class NotifikasiDropdown extends Component
{
    public bool $open = false;
    public array $notifikasi = [];
    public int $jumlahBelumBaca = 0;

    public function mount(): void
    {
        $this->loadNotifikasi();
    }

    public function loadNotifikasi(): void
    {
        $user = auth()->user()->fresh();
        $notif = collect();
        $lastRead = $user->notif_last_read_at
            ? \Carbon\Carbon::parse($user->notif_last_read_at)
            : null;

        if (in_array($user->role, ['pegawai', 'admin_diklat', 'super_admin'])) {
            $terdaftar = DB::table('record_absensi_diklats')
                ->where('id_user', $user->id)
                ->pluck('id_diklat');

            $acaraBaru = DB::table('m_diklats')
                ->where('publish', 1)
                ->where('status', 'Terbuka')
                ->whereNotIn('id', $terdaftar)
                ->where('created_at', '>=', now()->subDays(7))
                ->orderByDesc('created_at')
                ->limit(5)
                ->get()
                ->map(fn($a) => [
                    'icon'   => '🗓',
                    'judul'  => 'Acara Baru: ' . $a->nama,
                    'waktu'  => \Carbon\Carbon::parse($a->created_at)->diffForHumans(),
                    'warna'  => 'blue',
                    'is_new' => $lastRead === null || \Carbon\Carbon::parse($a->created_at)->gt($lastRead),
                ]);
            $notif = $notif->merge($acaraBaru);
        }

        if ($user->role === 'peserta_eksternal') {
            $acaraBaru = DB::table('m_diklats')
                ->where('publish', 1)
                ->where('status', 'Terbuka')
                ->where('created_at', '>=', now()->subDays(7))
                ->orderByDesc('created_at')
                ->limit(5)
                ->get()
                ->map(fn($a) => [
                    'icon'   => '🗓',
                    'judul'  => 'Acara Baru: ' . $a->nama,
                    'waktu'  => \Carbon\Carbon::parse($a->created_at)->diffForHumans(),
                    'warna'  => 'blue',
                    'is_new' => $lastRead === null || \Carbon\Carbon::parse($a->created_at)->gt($lastRead),
                ]);
            $notif = $notif->merge($acaraBaru);
        }

        $this->notifikasi = $notif->take(10)->values()->toArray();
        $this->jumlahBelumBaca = $notif->where('is_new', true)->count();
    }

    public function toggleOpen(): void
    {
        $this->open = !$this->open;
        if ($this->open) {
            $this->loadNotifikasi();
            auth()->user()->update(['notif_last_read_at' => now()]);
            $this->jumlahBelumBaca = 0;
        }
    }

    public function tutup(): void
    {
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.notifikasi-dropdown');
    }
}