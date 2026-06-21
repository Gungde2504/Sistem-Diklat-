<?php

namespace App\Livewire\Pegawai\DiklatMandiri;

use App\Models\DiklatMandiri;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

#[Title('Diklat Mandiri')]
class DiklatMandiriPegawai extends Component
{
    use WithFileUploads;

    public string $tab = 'riwayat'; // riwayat | form

    // Form fields
    #[Validate('required|string|max:255')]
    public string $nama = '';

    #[Validate('required|string|max:255')]
    public string $tempat = '';

    #[Validate('required|string')]
    public string $tglJamMulai = '';

    #[Validate('required|string')]
    public string $tglJamSelesai = '';

    #[Validate('required|integer|min:1')]
    public int $durasi = 60;

    #[Validate('required|file|mimes:pdf,jpg,jpeg,png|max:2048')]
    public $sertifikat = null;

    #[Validate('nullable|file|mimes:pdf,pptx,docx|max:5120')]
    public $materi = null;

    public bool $berhasil = false;

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
    }

    public function save(): void
    {
        $this->validate();

        $sertifikatPath = $this->sertifikat->store('diklat-mandiri/sertifikat', 'public');
        $materiPath     = $this->materi
            ? $this->materi->store('diklat-mandiri/materi', 'public')
            : null;

        DiklatMandiri::create([
            'nama'          => $this->nama,
            'jenisDiklat'   => 'Diklat Mandiri',
            'tempat'        => $this->tempat,
            'tglJamMulai'   => $this->tglJamMulai,
            'tglJamSelesai' => $this->tglJamSelesai,
            'durasi'        => $this->durasi,
            'sertifikat'    => $sertifikatPath,
            'materi'        => $materiPath,
            'id_user'       => auth()->id(),
            'status'        => 'pending',
        ]);

        $this->berhasil = true;
        $this->reset(['nama', 'tempat', 'tglJamMulai', 'tglJamSelesai', 'durasi', 'sertifikat', 'materi']);
        $this->tab = 'riwayat';
    }

    public function render()
    {
        $riwayat = DiklatMandiri::where('id_user', auth()->id())
            ->latest()
            ->get();

        $totalPending   = $riwayat->where('status', 'pending')->count();
        $totalDisetujui = $riwayat->where('status', 'Disetujui')->count();

        return view('livewire.pegawai.diklat-mandiri.diklat-mandiri-pegawai', compact(
            'riwayat', 'totalPending', 'totalDisetujui'
        ));
    }
}