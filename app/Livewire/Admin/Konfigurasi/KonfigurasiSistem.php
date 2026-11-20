<?php

namespace App\Livewire\Admin\Konfigurasi;

use App\Models\SistemKonfigurasi;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Konfigurasi Sistem')]
class KonfigurasiSistem extends Component
{
    public string $tab = 'geofencing';

    // Geofencing
    public string $rs_latitude  = '';
    public string $rs_longitude = '';
    public string $rs_radius    = '';
    public string $rs_nama      = '';
    public string $rs_alamat    = '';

    // Jam Pelatihan
    public string $target_jam_tahunan   = '';
    public string $batas_diklat_mandiri = '';
    public string $batas_elearning      = '';

    // Pengingat jam pelatihan
    public bool   $pengingat_aktif  = true;
    public string $pengingat_jadwal = '';

    // Aplikasi
    public string $app_nama     = '';
    public string $app_instansi = '';
    public string $app_tahun    = '';

    public function mount(): void
    {
        $this->loadConfig();
    }

    public function loadConfig(): void
    {
        $configs = SistemKonfigurasi::whereIn('key', [
            'rs_latitude', 'rs_longitude', 'rs_radius', 'rs_nama', 'rs_alamat',
            'target_jam_tahunan', 'batas_diklat_mandiri', 'batas_elearning',
            'pengingat_aktif', 'pengingat_jadwal',
            'app_nama', 'app_instansi', 'app_tahun',
        ])->pluck('value', 'key');

        $this->rs_latitude  = $configs->get('rs_latitude', '-8.674694');
        $this->rs_longitude = $configs->get('rs_longitude', '115.212806');
        $this->rs_radius    = $configs->get('rs_radius', '300');
        $this->rs_nama      = $configs->get('rs_nama', 'RSU Prima Medika');
        $this->rs_alamat    = $configs->get('rs_alamat', '');

        $this->target_jam_tahunan   = $configs->get('target_jam_tahunan', '20');
        $this->batas_diklat_mandiri = $configs->get('batas_diklat_mandiri', '10');
        $this->batas_elearning      = $configs->get('batas_elearning', '5');

        $this->pengingat_aktif  = $configs->get('pengingat_aktif', '1') === '1';
        $this->pengingat_jadwal = $configs->get('pengingat_jadwal', \App\Console\Commands\KirimPengingatJam::JADWAL_DEFAULT);

        $this->app_nama     = $configs->get('app_nama', 'Sistem Informasi Diklat & Seminar');
        $this->app_instansi = $configs->get('app_instansi', 'RSU Prima Medika');
        $this->app_tahun    = $configs->get('app_tahun', (string) now()->year);
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
    }

    public function simpanGeofencing(): void
    {
        $this->validate([
            'rs_latitude'  => 'required|numeric',
            'rs_longitude' => 'required|numeric',
            'rs_radius'    => 'required|numeric|min:50|max:5000',
            'rs_nama'      => 'required|string',
            'rs_alamat'    => 'nullable|string',
        ]);

        SistemKonfigurasi::set('rs_latitude',  $this->rs_latitude);
        SistemKonfigurasi::set('rs_longitude', $this->rs_longitude);
        SistemKonfigurasi::set('rs_radius',    $this->rs_radius);
        SistemKonfigurasi::set('rs_nama',      $this->rs_nama);
        SistemKonfigurasi::set('rs_alamat',    $this->rs_alamat);

        // Reload dari DB untuk pastikan nilai tersimpan benar
        $this->loadConfig();

        session()->flash('success', 'Konfigurasi geofencing berhasil disimpan.');
    }

    public function simpanJamPelatihan(): void
    {
        $this->validate([
            'target_jam_tahunan'   => 'required|numeric|min:1',
            'batas_diklat_mandiri' => 'required|numeric|min:0',
            'batas_elearning'      => 'required|numeric|min:0',
            // Daftar tanggal MM-DD dipisah koma, mis. 07-01,11-15,12-25
            'pengingat_jadwal'     => ['required', 'regex:/^\s*(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])(\s*,\s*(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))*\s*$/'],
        ], [
            'pengingat_jadwal.required' => 'Jadwal pengingat wajib diisi.',
            'pengingat_jadwal.regex'    => 'Format jadwal: bulan-tanggal dipisah koma, mis. 07-01,11-15,12-25.',
        ]);

        SistemKonfigurasi::set('target_jam_tahunan',   $this->target_jam_tahunan);
        SistemKonfigurasi::set('batas_diklat_mandiri', $this->batas_diklat_mandiri);
        SistemKonfigurasi::set('batas_elearning',      $this->batas_elearning);
        SistemKonfigurasi::set('pengingat_aktif',      $this->pengingat_aktif ? '1' : '0');
        SistemKonfigurasi::set('pengingat_jadwal',     preg_replace('/\s+/', '', $this->pengingat_jadwal));

        $this->loadConfig();

        session()->flash('success', 'Konfigurasi jam pelatihan berhasil disimpan.');
    }

    public function simpanAplikasi(): void
    {
        $this->validate([
            'app_nama'     => 'required|string',
            'app_instansi' => 'required|string',
            'app_tahun'    => 'required|numeric',
        ]);

        SistemKonfigurasi::set('app_nama',     $this->app_nama);
        SistemKonfigurasi::set('app_instansi', $this->app_instansi);
        SistemKonfigurasi::set('app_tahun',    $this->app_tahun);

        $this->loadConfig();

        session()->flash('success', 'Konfigurasi aplikasi berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.admin.konfigurasi.konfigurasi-sistem');
    }
}