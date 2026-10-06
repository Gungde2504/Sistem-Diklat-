<?php

namespace App\Livewire\Admin\Peserta;

use App\Actions\Sertifikat\GenerateSertifikatPklAction;
use App\Mail\PesertaStatusNotification;
use App\Models\DetailEksternal;
use App\Models\DiklatMandiri;
use App\Models\ExternalDailyAttendance;
use App\Models\RecordAbsensiDiklat;
use App\Models\ElearningProgress;
use App\Models\JurnalEksternal;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Title('Detail Peserta Eksternal')]
class PesertaDetail extends Component
{
    use WithPagination;
    use WithFileUploads;

    public DetailEksternal $detail;
    public string $tab        = 'absensi';
    public float  $nilaiInput = 0;
    public bool   $isKaryawan = false;
    public string $filterBulan = '';

    // Upload template
    public $templateDepan        = null;
    public $templateBelakang     = null;
    public string $templateDepanPath    = '';
    public string $templateBelakangPath = '';

    // Posisi overlay nama di sisi depan
    public int    $posX      = 530;
    public int    $posY      = 380;
    public int    $fontSize  = 36;
    public string $fontColor = '#1B3A5C';

    // Klik posisi
    public bool $clickMode  = false;
    public int  $templateW  = 1754;
    public int  $templateH  = 1240;

    public function mount(DetailEksternal $detail): void
    {
        $this->detail     = $detail->load(['user', 'unit', 'supervisor']);
        $this->nilaiInput = (float) ($detail->nilai_akhir ?? 0);
        $this->isKaryawan = DetailEksternal::isKaryawanExternal($detail->jenis);
        $this->tab        = $this->isKaryawan ? 'pelatihan' : 'absensi';
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function ubahStatus(string $status): void
    {
        $this->detail->update(['status' => $status]);
        $this->detail->refresh();
        session()->flash('success', 'Status berhasil diubah.');
    }

    public function approve(): void
    {
        $this->detail->update([
            'approval_status' => 'approved',
            'approved_by'     => auth()->id(),
            'approved_at'     => now(),
        ]);
        $this->detail->user?->update(['isActive' => true]);
        $this->detail->refresh()->load('user');
        $emailTerkirim = $this->kirimEmailStatus();
        session()->flash('success', $emailTerkirim
            ? 'Peserta berhasil disetujui dan email notifikasi telah dikirim.'
            : 'Peserta berhasil disetujui, tetapi email notifikasi gagal dikirim.');
    }

    public function reject(): void
    {
        $this->detail->update([
            'approval_status' => 'rejected',
            'approved_by'     => auth()->id(),
            'approved_at'     => now(),
        ]);
        $this->detail->user?->update(['isActive' => false]);
        $this->detail->refresh()->load('user');
        $emailTerkirim = $this->kirimEmailStatus();
        session()->flash('success', $emailTerkirim
            ? 'Peserta ditolak dan email notifikasi telah dikirim.'
            : 'Peserta ditolak, tetapi email notifikasi gagal dikirim.');
    }

    private function kirimEmailStatus(): bool
    {
        if (!$this->detail->user?->email) {
            return false;
        }

        try {
            Mail::to($this->detail->user->email)
                ->send(new PesertaStatusNotification($this->detail));
            return true;
        } catch (\Throwable $e) {
            report($e);
            return false;
        }
    }

    public function simpanNilai(): void
    {
        $this->validate(['nilaiInput' => 'required|numeric|min:0|max:100']);
        $this->detail->update(['nilai_akhir' => $this->nilaiInput]);
        $this->detail->refresh();
        session()->flash('success', 'Nilai berhasil disimpan.');
    }

    public function uploadTemplateDepan(): void
    {
        $this->validate(['templateDepan' => 'required|image|mimes:jpg,jpeg,png|max:5120']);
        $path = $this->templateDepan->store('sertifikat-pkl/templates', 'public');
        $this->templateDepanPath = $path;
        $this->templateDepan     = null;

        $fullPath = storage_path('app/public/' . $path);
        if (file_exists($fullPath)) {
            [$w, $h] = getimagesize($fullPath);
            $this->templateW = $w;
            $this->templateH = $h;
        }

        session()->flash('success', 'Template depan berhasil diupload.');
    }

    public function uploadTemplateBelakang(): void
    {
        $this->validate(['templateBelakang' => 'required|image|mimes:jpg,jpeg,png|max:5120']);
        $path = $this->templateBelakang->store('sertifikat-pkl/templates', 'public');
        $this->templateBelakangPath = $path;
        $this->templateBelakang     = null;
        session()->flash('success', 'Template belakang berhasil diupload.');
    }

    public function setPositionFromClick(int $clickX, int $clickY, int $imgW, int $imgH): void
    {
        $this->posX = (int) round(($clickX / $imgW) * $this->templateW);
        $this->posY = (int) round(($clickY / $imgH) * $this->templateH);
        $this->clickMode = false;
    }

    public function generateSertifikatPkl(): void
    {
        if (!$this->templateDepanPath || !$this->templateBelakangPath) {
            session()->flash('error', 'Upload template sisi depan dan belakang terlebih dahulu.');
            return;
        }

        $result = app(GenerateSertifikatPklAction::class)->execute(
            detail:            $this->detail,
            frontTemplatePath: $this->templateDepanPath,
            backTemplatePath:  $this->templateBelakangPath,
            posX:              $this->posX,
            posY:              $this->posY,
            fontSize:          $this->fontSize,
            fontColor:         $this->fontColor,
        );

        $this->detail->refresh();

        if ($result['success']) {
            session()->flash('success', $result['message']);
        } else {
            session()->flash('error', $result['message']);
        }
    }

    public function render()
    {
        // ── KARYAWAN EXTERNAL ──
        if ($this->isKaryawan) {
            $absensi = RecordAbsensiDiklat::with('diklat')
                ->where('id_user', $this->detail->id_user)
                ->orderByDesc('date')
                ->paginate(15);

            $totalHadir        = RecordAbsensiDiklat::where('id_user', $this->detail->id_user)
                ->where('is_hadir', true)->count();
            $totalAbsensi      = RecordAbsensiDiklat::where('id_user', $this->detail->id_user)
                ->count();
            $totalJamPelatihan = RecordAbsensiDiklat::where('id_user', $this->detail->id_user)
                ->where('is_hadir', true)->sum('durasi');

            $elearning = ElearningProgress::with('modul')
                ->where('id_user', $this->detail->id_user)
                ->orderByDesc('updated_at')
                ->paginate(10, ['*'], 'elearning_page');

            $totalElearning = ElearningProgress::where('id_user', $this->detail->id_user)->count();
            $totalCompleted = ElearningProgress::where('id_user', $this->detail->id_user)
                ->where('status', 'completed')->count();

            $diklatMandiri = DiklatMandiri::where('id_user', $this->detail->id_user)
                ->orderByDesc('tglJamMulai')
                ->paginate(10, ['*'], 'diklat_mandiri_page');

            $totalDiklatMandiri         = DiklatMandiri::where('id_user', $this->detail->id_user)->count();
            $totalDiklatMandiriApproved = DiklatMandiri::where('id_user', $this->detail->id_user)
                ->where('status', 'Disetujui')->count();
            $totalDiklatMandiriPending  = DiklatMandiri::where('id_user', $this->detail->id_user)
                ->where('status', 'pending')->count();

            return view('livewire.admin.peserta.peserta-detail-karyawan', compact(
                'absensi', 'totalHadir', 'totalAbsensi', 'totalJamPelatihan',
                'elearning', 'totalElearning', 'totalCompleted',
                'diklatMandiri', 'totalDiklatMandiri', 'totalDiklatMandiriApproved', 'totalDiklatMandiriPending'
            ));
        }

        // ── PKL / MAGANG ──
        $absensi = ExternalDailyAttendance::where('id_user', $this->detail->id_user)
            ->when($this->filterBulan, fn($q) => $q->whereMonth('tanggal', $this->filterBulan))
            ->orderByDesc('tanggal')
            ->paginate(15);

        $totalHadir   = ExternalDailyAttendance::where('id_user', $this->detail->id_user)
            ->where('is_valid', 1)->count();
        $totalAbsensi = ExternalDailyAttendance::where('id_user', $this->detail->id_user)
            ->count();

        return view('livewire.admin.peserta.peserta-detail', compact(
            'absensi', 'totalHadir', 'totalAbsensi'
        ));
    }
}
