<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

// Verifikasi Sertifikat — Publik (tanpa login)
Route::get('/sertifikat/verify/{token}', function (string $token) {
    $detail = \App\Models\DetailEksternal::where('cert_qr_token', $token)
        ->with(['user', 'unit', 'supervisor'])
        ->first();
    return view('public.verify-sertifikat', compact('detail'));
})->name('sertifikat.verify');

// Absensi via QR Scan
Route::get('/absensi/scan/{token}', [\App\Http\Controllers\AbsensiQrController::class, 'show'])
    ->name('absensi.scan');
Route::post('/absensi/scan/{token}', [\App\Http\Controllers\AbsensiQrController::class, 'login'])
    ->name('absensi.scan.login');
Route::post('/absensi/scan/{token}/confirm', [\App\Http\Controllers\AbsensiQrController::class, 'confirm'])
    ->name('absensi.scan.confirm');
    
// Peserta External (PKL/Magang/Orientasi)
Route::get('/daftar-external', function () {
    $units       = \App\Models\MUnit::orderBy('nama')->get();
    $supervisors = \App\Models\User::where('type', 'internal')
        ->where('isActive', 1)->orderBy('nama')->get();
    return view('public.daftar-external', compact('units', 'supervisors'));
})->name('daftar.external');

Route::post('/daftar-external', \App\Http\Controllers\Public\DaftarExternalController::class)
    ->name('daftar.external.store');

// Karyawan External (ISS/BSS/dll)
Route::get('/daftar-karyawan-external', function () {
    $units       = \App\Models\MUnit::orderBy('nama')->get();
    $supervisors = \App\Models\User::where('type', 'internal')
        ->where('isActive', 1)->orderBy('nama')->get();
    return view('public.daftar-karyawan-external', compact('units', 'supervisors'));
})->name('daftar.karyawan.external');

Route::post('/daftar-karyawan-external', \App\Http\Controllers\Public\DaftarKaryawanExternalController::class)
    ->name('daftar.karyawan.external.store');

// Sukses
Route::get('/daftar-external/sukses', fn() => view('public.daftar-external-sukses'))
    ->name('daftar.external.sukses');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (BREEZE)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| AFTER LOGIN (ROLE BASED SYSTEM)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |----------------------------------------------------------------------
    | ADMIN (super_admin + admin_diklat)
    |----------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:super_admin,admin_diklat'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/acara/tambah', function () {
                return view('admin.acara.create');
            })->name('acara.create');

            Route::get('/acara', function () {
                return view('admin.acara.index');
            })->name('acara.index');

            Route::get('/acara/{diklat}/edit', function (\App\Models\MDiklat $diklat) {
                return view('admin.acara.edit', compact('diklat'));
            })->name('acara.edit');

            Route::get('/acara/{diklat}/sertifikat', function (\App\Models\MDiklat $diklat) {
                return view('admin.acara.sertifikat', compact('diklat'));
            })->name('acara.sertifikat');

            Route::get('/acara/{diklat}', function (\App\Models\MDiklat $diklat) {
                return view('admin.acara.detail', compact('diklat'));
            })->name('acara.detail');


            Route::get('/absensi/{diklat}/qr', function (\App\Models\MDiklat $diklat) {
                return view('admin.absensi.tampil-qr', compact('diklat'));
            })->name('absensi.tampil-qr');

            Route::get('/absensi/{diklat}/download', [\App\Http\Controllers\Admin\AbsensiDownloadController::class, 'download'])->name('absensi.download');

            // Peserta Eksternal
            Route::get('/peserta', fn() => view('admin.peserta.index'))->name('peserta.index');
            Route::get('/peserta/tambah', fn() => view('admin.peserta.create'))->name('peserta.create');
            Route::get('/peserta/{detail}/edit', fn(\App\Models\DetailEksternal $detail) => view('admin.peserta.edit', compact('detail')))->name('peserta.edit');
            Route::get('/peserta/{detail}', function (\App\Models\DetailEksternal $detail) {
                return view('admin.peserta.detail', compact('detail'));
            })->name('peserta.detail');
            Route::get('/peserta/{detail}/karyawan', fn(\App\Models\DetailEksternal $detail) => view('admin.peserta.detail-karyawan', compact('detail')))->name('peserta.detail.karyawan');

            Route::get('/diklat-mandiri', fn() => view('admin.diklat-mandiri.index'))
                ->name('diklat-mandiri.index');

            Route::get('/rekap-jam', fn() => view('admin.rekap-jam.index'))
                ->name('rekap-jam.index');

            Route::get('/laporan', fn() => view('admin.laporan.index'))
                ->name('laporan.index');

            Route::post('/acara/{diklat}/sampul', [\App\Http\Controllers\Admin\AcaraSampulController::class, 'upload'])->name('acara.sampul.upload');
            Route::delete('/acara/{diklat}/sampul', [\App\Http\Controllers\Admin\AcaraSampulController::class, 'hapus'])->name('acara.sampul.hapus');

            Route::get('/acara/{diklat}/foto', function (\App\Models\MDiklat $diklat) {
                return view('admin.acara.foto', compact('diklat'));
            })->name('acara.foto');

            Route::post('/acara/{diklat}/foto/upload', [\App\Http\Controllers\Admin\FotoDokumentasiController::class, 'upload'])->name('acara.foto.upload');

            Route::delete('/acara/{diklat}/foto/{foto}', [\App\Http\Controllers\Admin\FotoDokumentasiController::class, 'hapus'])->name('acara.foto.hapus');

            Route::get('/konfigurasi', fn() => view('admin.konfigurasi.index'))
                ->name('konfigurasi.index')
                ->middleware('role:super_admin');
            // E-Learning Admin
            Route::get('/elearning', fn() => view('admin.e-learning.index'))->name('elearning.index');
            Route::get('/elearning/create', fn() => view('admin.e-learning.create'))->name('elearning.create');
            Route::get('/elearning/{modul}', fn(\App\Models\ElearningModule $modul) => view('admin.e-learning.show', compact('modul')))->name('elearning.show');
            Route::get('/elearning/{modul}/edit', fn(\App\Models\ElearningModule $modul) => view('admin.e-learning.edit', compact('modul')))->name('elearning.edit');
        });


    /*
|----------------------------------------------------------------------
| PEGAWAI
|----------------------------------------------------------------------
*/
    Route::middleware(['auth', 'role:pegawai'])
        ->prefix('pegawai')
        ->name('pegawai.')
        ->group(function () {
            Route::get('/dashboard', fn() => view('pegawai.dashboard'))->name('dashboard');

            Route::get('/acara', fn() => view('pegawai.acara.index'))->name('acara');
            Route::get('/acara/{diklat}', function (\App\Models\MDiklat $diklat) {
                return view('pegawai.acara.detail', compact('diklat'));
            })->name('acara.detail');

            Route::get('/scan', fn() => view('pegawai.dashboard'))->name('scan');
            Route::get('/rekap-jam', fn() => view('pegawai.rekap-jam.index'))->name('rekap-jam');

            Route::get('/diklat-mandiri', fn() => view('pegawai.diklat-mandiri.index'))
                ->name('diklat-mandiri');

            Route::get('/diklat-mandiri/{diklat}', function (\App\Models\DiklatMandiri $diklat) {
                return view('pegawai.diklat-mandiri.detail', compact('diklat'));
            })->name('diklat-mandiri.detail');

            Route::get('/sertifikat', fn() => view('pegawai.sertifikat.index'))->name('sertifikat');

            Route::get('/profil', fn() => view('pegawai.profil.index'))->name('profil');

            // E-Learning Pegawai
            Route::get('/elearning', fn() => view('pegawai.e-learning.index'))->name('elearning');
            Route::get('/elearning/{modul}', fn(\App\Models\ElearningModule $modul) => view('pegawai.e-learning.detail', compact('modul')))->name('elearning.detail');
        });
    /*
    |----------------------------------------------------------------------
    | EKSTERNAL
    |----------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:peserta_eksternal'])
        ->prefix('eksternal')
        ->name('eksternal.')
        ->group(function () {
            Route::get('/dashboard', fn() => view('eksternal.dashboard'))->name('dashboard');
            Route::get('/absensi', fn() => view('eksternal.absensi.index'))->name('absensi');
            Route::get('/rekap', fn() => view('eksternal.absensi.rekap'))->name('rekap');
            Route::get('/rekap/download', [\App\Http\Controllers\Eksternal\RekapAbsensiController::class, 'download'])->name('rekap.download');
            Route::get('/jurnal', fn() => view('eksternal.jurnal.index'))->name('jurnal');
            Route::get('/jurnal/download', [\App\Http\Controllers\Eksternal\JurnalDownloadController::class, 'download'])->name('jurnal.download');
            Route::get('/acara', fn() => view('eksternal.acara.index'))->name('acara');
            Route::get('/acara/{diklat}', fn(\App\Models\MDiklat $diklat) => view('eksternal.acara.detail', compact('diklat')))->name('acara.detail');
            Route::get('/sertifikat', fn() => view('eksternal.sertifikat.index'))->name('sertifikat');
            Route::get('/profil', fn() => view('eksternal.profil.index'))->name('profil');
            Route::put('/profil/update', [\App\Http\Controllers\Eksternal\ProfilController::class, 'update'])->name('profil.update');
            Route::put('/profil/password', [\App\Http\Controllers\Eksternal\ProfilController::class, 'gantiPassword'])->name('profil.password');
        });

    /*
    |----------------------------------------------------------------------
    | PROFILE (Breeze)
    |----------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
