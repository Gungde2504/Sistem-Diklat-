<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Inspiring;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// 1. Update status peserta external — daily jam 00:00
Schedule::call(function () {
    try {
        $updated = \App\Models\DetailEksternal::where('status', 'aktif')
            ->where('approval_status', 'approved')
            ->whereNotNull('tanggal_selesai')
            ->where('tanggal_selesai', '<', now()->toDateString())
            ->update(['status' => 'selesai']);

        \Illuminate\Support\Facades\Log::info('[Scheduler] Status eksternal diupdate: '.$updated.' data - '.now());
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('[Scheduler] Error update-status-eksternal: '.$e->getMessage());
    }
})->daily()->name('update-status-eksternal');

// 2. Update status acara – setiap menit
Schedule::call(function () {
    try {
        $now = now()->format('Y-m-d\TH:i');
        
        \App\Models\MDiklat::where('publish', 1)
            ->where('status', 'Draft')
            ->where('tglJamMulai', '>', $now)
            ->update(['status' => 'Terbuka']);

        \App\Models\MDiklat::where('publish', 1)
            ->whereIn('status', ['Draft', 'Terbuka'])
            ->where('tglJamMulai', '<=', $now)
            ->where('tglJamSelesai', '>=', $now)
            ->update(['status' => 'Berlangsung']);

        \App\Models\MDiklat::where('publish', 1)
            ->whereIn('status', ['Draft', 'Terbuka', 'Berlangsung'])
            ->where('tglJamSelesai', '<', $now)
            ->update(['status' => 'Selesai']);

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('[Scheduler] Error update-status-acara: '.$e->getMessage());
    }
})->everyMinute()->name('update-status-acara');