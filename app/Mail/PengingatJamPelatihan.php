<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengingatJamPelatihan extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nama,
        public float  $jamSaatIni,
        public float  $target,
        public float  $jamAcara,
        public float  $jamMandiri,
        public float  $jamElearning,
        public int    $tahun,
        public int    $sisaBulan,
        public string $tingkat,      // ringan | sedang | tegas | terakhir
        public string $role,         // pegawai | peserta_eksternal
    ) {}

    public function build(): self
    {
        $kurang = max(0, round($this->target - $this->jamSaatIni, 1));

        $subject = match ($this->tingkat) {
            'terakhir' => 'Pengingat Terakhir: Jam Pelatihan Anda Masih Kurang ' . $this->fmt($kurang) . ' Jam',
            'tegas'    => 'Penting: Jam Pelatihan Anda Masih Kurang ' . $this->fmt($kurang) . ' Jam',
            default    => 'Pengingat Jam Pelatihan ' . $this->tahun . ' - RSU Prima Medika',
        };

        $url = route('login');

        return $this->subject($subject)
            ->view('emails.pengingat-jam')
            ->with([
                'nama'         => $this->nama,
                'jamSaatIni'   => $this->fmt($this->jamSaatIni),
                'target'       => $this->fmt($this->target),
                'kurang'       => $this->fmt($kurang),
                'jamAcara'     => $this->fmt($this->jamAcara),
                'jamMandiri'   => $this->fmt($this->jamMandiri),
                'jamElearning' => $this->fmt($this->jamElearning),
                'tahun'        => $this->tahun,
                'sisaBulan'    => $this->sisaBulan,
                'tingkat'      => $this->tingkat,
                'tampilMandiri' => $this->role === 'pegawai',
                'loginUrl'     => $url,
            ]);
    }

    private function fmt(float $v): string
    {
        return rtrim(rtrim(number_format($v, 1, ',', '.'), '0'), ',');
    }
}
