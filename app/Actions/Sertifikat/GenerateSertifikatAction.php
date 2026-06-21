<?php

namespace App\Actions\Sertifikat;

use App\Models\MFileDiklat;
use App\Models\MDiklat;
use App\Models\RecordAbsensiDiklat;
use App\Helpers\SertifikatHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GenerateSertifikatAction
{
    public function execute(
        MDiklat $diklat,
        string  $templatePath,
        int     $posX,
        int     $posY,
        int     $fontSize,
        string  $fontColor,
        string  $fontAlign,
        bool    $includeDate,
        int     $posDateX,
        int     $posDateY,
    ): array {
        $pesertaList = RecordAbsensiDiklat::with('user')
            ->where('id_diklat', $diklat->id)
            ->get();

        if ($pesertaList->isEmpty()) {
            return ['success' => false, 'message' => 'Tidak ada peserta yang hadir.'];
        }

        $fontPath = public_path('fonts/OpenSans-Bold.ttf');
        $manager  = new ImageManager(new Driver());
        $generated = 0;
        $folder    = 'sertifikat/' . $diklat->id;

        foreach ($pesertaList as $peserta) {
            try {
                $namaPeserta = $peserta->namaPeserta ?? $peserta->user?->nama ?? 'Peserta';
                $nomorSert   = SertifikatHelper::generateNomor($diklat, $peserta->id);

                $img = $manager->read(Storage::disk('public')->path($templatePath));

                $img->text($namaPeserta, $posX, $posY, function ($font) use ($fontSize, $fontColor, $fontPath, $fontAlign) {
                    if (file_exists($fontPath)) $font->file($fontPath);
                    $font->size($fontSize);
                    $font->color($fontColor);
                    $font->align($fontAlign);
                    $font->valign('middle');
                });

                if ($includeDate) {
                    $tanggal = \Carbon\Carbon::parse($diklat->tglJamMulai)->translatedFormat('d F Y');
                    $img->text($tanggal, $posDateX, $posDateY, function ($font) use ($fontSize, $fontColor, $fontPath) {
                        if (file_exists($fontPath)) $font->file($fontPath);
                        $font->size($fontSize - 4);
                        $font->color($fontColor);
                        $font->align('center');
                        $font->valign('middle');
                    });
                }

                $filename = $folder . '/' . Str::slug($namaPeserta) . '-' . Str::random(6) . '.jpg';
                Storage::disk('public')->put($filename, $img->toJpeg(90));

                MFileDiklat::updateOrCreate(
                    [
                        'id_diklat'  => $diklat->id,
                        'type'       => 'sertifikat',
                        'created_by' => $peserta->id_user,
                    ],
                    [
                        'file'            => $filename,
                        'nomor_sertifikat' => $nomorSert,
                    ]
                );

                $generated++;

            } catch (\Exception $e) {
                \Log::error('Generate sertifikat error: ' . $e->getMessage());
            }
        }

        return [
            'success' => true,
            'message' => "Berhasil generate {$generated} sertifikat dari {$pesertaList->count()} peserta.",
            'total'   => $generated,
        ];
    }
}