<?php

namespace App\Mail;

use App\Models\DetailEksternal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PesertaStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public DetailEksternal $detail;
    public bool $isApproved;

    /**
     * @param DetailEksternal $detail Harus sudah memuat relasi 'user'.
     */
    public function __construct(DetailEksternal $detail)
    {
        $this->detail     = $detail;
        $this->isApproved = $detail->approval_status === 'approved';
    }

    public function build(): self
    {
        $subject = $this->isApproved
            ? 'Pendaftaran Anda Disetujui - RSU Prima Medika'
            : 'Pendaftaran Anda Ditolak - RSU Prima Medika';

        return $this->subject($subject)
            ->view('emails.peserta-status')
            ->with([
                'nama'       => $this->detail->user->nama ?? $this->detail->user->name ?? 'Peserta',
                'isApproved' => $this->isApproved,
                'loginUrl'   => route('login'),
            ]);
    }
}
