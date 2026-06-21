<?php

namespace App\Actions\Sertifikat;

use App\Models\DetailEksternal;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GenerateSertifikatPklAction
{
    public function execute(
        DetailEksternal $detail,
        string $frontTemplatePath,
        string $backTemplatePath,
        int    $posX      = 530,
        int    $posY      = 380,
        int    $fontSize  = 36,
        string $fontColor = '#1B3A5C',
    ): array {
        try {
            $user    = $detail->user;
            $manager = new ImageManager(new Driver());
            $token   = Str::uuid()->toString();
            $detail->update(['cert_qr_token' => $token]);

            $folder   = 'sertifikat-pkl/' . $detail->id;
            $fontPath = public_path('fonts/OpenSans-Bold.ttf');
            $nomor    = 'SERT/PKL/' . now()->format('Y/m') . '/' . str_pad($detail->id, 4, '0', STR_PAD_LEFT);

            // ── SISI DEPAN ──
            $imgDepan = $manager->read(Storage::disk('public')->path($frontTemplatePath));

            $imgDepan->text($user->nama, $posX, $posY, function ($font) use ($fontSize, $fontColor, $fontPath) {
                if (file_exists($fontPath)) $font->file($fontPath);
                $font->size($fontSize);
                $font->color($fontColor);
                $font->align('center');
                $font->valign('middle');
            });

            $imgDepan->text($nomor, $posX, $posY + $fontSize + 12, function ($font) use ($fontPath) {
                if (file_exists($fontPath)) $font->file($fontPath);
                $font->size(16);
                $font->color('#888888');
                $font->align('center');
                $font->valign('middle');
            });

            $frontPath = $folder . '/depan-' . Str::random(6) . '.jpg';
            Storage::disk('public')->put($frontPath, $imgDepan->toJpeg(90));

            // ── SISI BELAKANG ──
            $imgBelakang = $manager->read(Storage::disk('public')->path($backTemplatePath));

            // Generate QR — ukuran lebih kecil, posisi sejajar tabel keterangan nilai
            $qrSize     = 130;
            $verifyUrl  = url('/sertifikat/verify/' . $token);
            $qrTempPath = $this->generateQrPng($verifyUrl, $qrSize);

            if ($qrTempPath) {
                $imgW = $imgBelakang->width();
                $imgH = $imgBelakang->height();

                // Sejajar tabel keterangan nilai, geser kiri dari TTD
                $qrX = (int) round($imgW * 0.52);
                $qrY = (int) round($imgH * 0.80);

                // Safety: jangan keluar dari gambar
                $qrX = min($qrX, $imgW - ($qrSize + 10));
                $qrY = min($qrY, $imgH - ($qrSize + 10));

                $imgBelakang->place($qrTempPath, 'top-left', $qrX, $qrY);
                @unlink($qrTempPath);
            }

            $backPath = $folder . '/belakang-' . Str::random(6) . '.jpg';
            Storage::disk('public')->put($backPath, $imgBelakang->toJpeg(90));

            $detail->update([
                'cert_file_path' => $frontPath,
                'cert_back_path' => $backPath,
            ]);

            return [
                'success' => true,
                'message' => 'Sertifikat berhasil digenerate!',
                'token'   => $token,
                'front'   => $frontPath,
                'back'    => $backPath,
            ];

        } catch (\Exception $e) {
            \Log::error('Generate sertifikat PKL error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function generateQrPng(string $text, int $size = 130): ?string
    {
        try {
            $encoder = new \BaconQrCode\Encoder\Encoder();
            $qrCode  = $encoder->encode(
                $text,
                \BaconQrCode\Common\ErrorCorrectionLevel::H()
            );
            $matrix   = $qrCode->getMatrix();
            $width    = $matrix->getWidth();

            $tempPng  = storage_path('app/temp-qr-' . Str::random(6) . '.png');
            $cellSize = (int) floor($size / ($width + 8));
            $margin   = (int) floor(($size - $cellSize * $width) / 2);

            $img   = imagecreatetruecolor($size, $size);
            $white = imagecolorallocate($img, 255, 255, 255);
            $black = imagecolorallocate($img, 0, 0, 0);
            imagefill($img, 0, 0, $white);

            for ($y = 0; $y < $width; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    if ($matrix->get($x, $y) === 1) {
                        $x1 = $margin + $x * $cellSize;
                        $y1 = $margin + $y * $cellSize;
                        $x2 = $x1 + $cellSize - 1;
                        $y2 = $y1 + $cellSize - 1;
                        imagefilledrectangle($img, $x1, $y1, $x2, $y2, $black);
                    }
                }
            }

            imagepng($img, $tempPng);
            imagedestroy($img);

            return $tempPng;

        } catch (\Exception $e) {
            \Log::error('QR generate error: ' . $e->getMessage());
            return null;
        }
    }

    private function drawPolygon($img, array $points, float $scale, float $tx, float $ty, $color): void
    {
        if (count($points) < 3) return;

        $gdPoints = [];
        foreach ($points as $p) {
            $gdPoints[] = (int) round(($p[0] + $tx) * $scale);
            $gdPoints[] = (int) round(($p[1] + $ty) * $scale);
        }

        if (count($gdPoints) >= 6) {
            imagefilledpolygon($img, $gdPoints, $color);
        }
    }
}