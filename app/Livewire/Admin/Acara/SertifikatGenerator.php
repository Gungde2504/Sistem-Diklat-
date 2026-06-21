<?php

namespace App\Livewire\Admin\Acara;

use App\Actions\Sertifikat\GenerateSertifikatAction;
use App\Models\MDiklat;
use App\Models\MFileDiklat;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

#[Title('Generate Sertifikat')]
class SertifikatGenerator extends Component
{
    use WithFileUploads;

    public MDiklat $diklat;

    public $template        = null;
    public string $templatePath = '';

    public int    $posX      = 760;
    public int    $posY      = 430;
    public int    $fontSize  = 48;
    public string $fontColor = '#1B3A5C';
    public string $fontAlign = 'center';

    public bool   $includeDate = true;
    public int    $posDateX    = 760;
    public int    $posDateY    = 490;

    // Mode klik aktif: 'nama' atau 'tanggal' atau null
    public ?string $clickMode = null;

    public string $message     = '';
    public string $messageType = '';
    public bool   $isGenerating = false;

    // Dimensi asli template (untuk konversi koordinat)
    public int $templateW = 1754;
    public int $templateH = 1240;

    public function mount(MDiklat $diklat): void
    {
        $this->diklat = $diklat;

        $existing = MFileDiklat::where('id_diklat', $diklat->id)
            ->where('type', 'template_sertifikat')
            ->latest()
            ->first();

        if ($existing) {
            $this->templatePath = $existing->file;
            // Ambil dimensi asli gambar
            $fullPath = storage_path('app/public/' . $existing->file);
            if (file_exists($fullPath)) {
                [$w, $h] = getimagesize($fullPath);
                $this->templateW = $w;
                $this->templateH = $h;
            }
        }
    }

    public function setClickMode(string $mode): void
    {
        $this->clickMode = $this->clickMode === $mode ? null : $mode;
    }

    public function setPositionFromClick(int $clickX, int $clickY, int $imgW, int $imgH): void
    {
        // Konversi koordinat layar ke koordinat piksel asli template
        $realX = (int) round(($clickX / $imgW) * $this->templateW);
        $realY = (int) round(($clickY / $imgH) * $this->templateH);

        if ($this->clickMode === 'nama') {
            $this->posX = $realX;
            $this->posY = $realY;
        } elseif ($this->clickMode === 'tanggal') {
            $this->posDateX = $realX;
            $this->posDateY = $realY;
        }

        $this->clickMode = null; // reset setelah klik
    }

    public function uploadTemplate(): void
    {
        $this->validate([
            'template' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $path = $this->template->store('sertifikat/templates', 'public');

        MFileDiklat::updateOrCreate(
            ['id_diklat' => $this->diklat->id, 'type' => 'template_sertifikat'],
            ['file' => $path]
        );

        $this->templatePath = $path;
        $this->template     = null;

        // Ambil dimensi
        $fullPath = storage_path('app/public/' . $path);
        if (file_exists($fullPath)) {
            [$w, $h] = getimagesize($fullPath);
            $this->templateW = $w;
            $this->templateH = $h;
        }

        $this->message     = 'Template berhasil diupload!';
        $this->messageType = 'success';
    }

    public function generate(): void
    {
        if (!$this->templatePath) {
            $this->message     = 'Upload template sertifikat terlebih dahulu.';
            $this->messageType = 'error';
            return;
        }

        $this->isGenerating = true;

        $result = app(GenerateSertifikatAction::class)->execute(
            diklat:       $this->diklat,
            templatePath: $this->templatePath,
            posX:         $this->posX,
            posY:         $this->posY,
            fontSize:     $this->fontSize,
            fontColor:    $this->fontColor,
            fontAlign:    $this->fontAlign,
            includeDate:  $this->includeDate,
            posDateX:     $this->posDateX,
            posDateY:     $this->posDateY,
        );

        $this->isGenerating = false;
        $this->message      = $result['message'];
        $this->messageType  = $result['success'] ? 'success' : 'error';
    }

    public function deleteTemplate(): void
    {
        MFileDiklat::where('id_diklat', $this->diklat->id)
            ->where('type', 'template_sertifikat')
            ->delete();

        $this->templatePath = '';
        $this->message      = 'Template dihapus.';
        $this->messageType  = 'success';
    }

    public function render()
    {
        $sertifikatGenerated = MFileDiklat::where('id_diklat', $this->diklat->id)
            ->where('type', 'sertifikat')
            ->count();

        $totalPeserta = $this->diklat->absensiDiklats()->count();

        return view('livewire.admin.acara.sertifikat-generator', compact(
            'sertifikatGenerated', 'totalPeserta'
        ));
    }
}