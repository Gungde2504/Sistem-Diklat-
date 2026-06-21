<?php

namespace App\Livewire\Eksternal\Absensi;

use App\Actions\Absensi\CheckinGpsAction;
use App\Models\ExternalDailyAttendance;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Absensi Harian')]
class AbsensiHarian extends Component
{
    public float  $latitude   = 0;
    public float  $longitude  = 0;
    public bool   $gpsReady   = false;
    public bool   $gpsValid   = false;
    public float  $jarak      = 0;
    public string $message    = '';
    public string $messageType = '';

    public function setLocation(float $lat, float $lng, bool $valid, float $jarak): void
    {
        $this->latitude  = $lat;
        $this->longitude = $lng;
        $this->gpsReady  = true;
        $this->gpsValid  = $valid;
        $this->jarak     = $jarak;
    }

    public function checkin(): void
    {
        if (!$this->gpsReady) {
            $this->message     = 'Aktifkan GPS terlebih dahulu.';
            $this->messageType = 'error';
            return;
        }

        $today = now()->toDateString();
        $user  = auth()->user();

        // Cek sudah checkin
        $existing = ExternalDailyAttendance::where('id_user', $user->id)
            ->where('tanggal', $today)
            ->first();

        if ($existing) {
            $this->message     = 'Anda sudah melakukan check-in hari ini.';
            $this->messageType = 'warning';
            return;
        }

        ExternalDailyAttendance::create([
            'id_user'    => $user->id,
            'tanggal'    => $today,
            'checkin_at' => now(),
            'mode'       => 'gps',
            'latitude'   => $this->latitude,
            'longitude'  => $this->longitude,
            'is_valid'   => $this->gpsValid ? 1 : 0,
        ]);

        $this->message     = $this->gpsValid
            ? '✅ Check-in berhasil! Lokasi valid.'
            : '⚠️ Check-in tercatat namun lokasi di luar radius RS.';
        $this->messageType = $this->gpsValid ? 'success' : 'warning';
    }

    public function checkout(): void
    {
        if (!$this->gpsReady) {
            $this->message     = 'Aktifkan GPS terlebih dahulu.';
            $this->messageType = 'error';
            return;
        }

        $today = now()->toDateString();
        $user  = auth()->user();

        $absensi = ExternalDailyAttendance::where('id_user', $user->id)
            ->where('tanggal', $today)
            ->first();

        if (!$absensi) {
            $this->message     = 'Anda belum melakukan check-in hari ini.';
            $this->messageType = 'error';
            return;
        }

        if ($absensi->checkout_at) {
            $this->message     = 'Anda sudah melakukan check-out hari ini.';
            $this->messageType = 'warning';
            return;
        }

        $absensi->update([
            'checkout_at' => now(),
            'latitude'    => $this->latitude,
            'longitude'   => $this->longitude,
        ]);

        $this->message     = $this->gpsValid
            ? '✅ Check-out berhasil!'
            : '⚠️ Check-out tercatat namun lokasi di luar radius RS.';
        $this->messageType = $this->gpsValid ? 'success' : 'warning';
    }

    public function render()
    {
        $userId = auth()->id();
        $today  = now()->toDateString();

        $absensiHarini = ExternalDailyAttendance::where('id_user', $userId)
            ->where('tanggal', $today)
            ->first();

        $riwayat = ExternalDailyAttendance::where('id_user', $userId)
            ->orderByDesc('tanggal')
            ->limit(7)
            ->get();

        return view('livewire.eksternal.absensi.absensi-harian', compact(
            'absensiHarini', 'riwayat'
        ));
    }
}