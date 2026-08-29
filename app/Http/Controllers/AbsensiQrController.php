<?php
namespace App\Http\Controllers;
use App\Models\MDiklat;
use App\Models\User;
use App\Models\RecordAbsensiDiklat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AbsensiQrController extends Controller
{
    public function show(string $token)
    {
        $diklat = MDiklat::where('QRcode', $token)
            ->where('IsActive', 1)
            ->firstOrFail();

        // Kalau sudah login, langsung tampilkan card konfirmasi tanpa form
        if (Auth::check()) {
            $user = Auth::user()->load('detailEksternal');
            return view('absensi.scan-confirm', compact('diklat', 'token', 'user'));
        }

        return view('absensi.scan-login', compact('diklat', 'token'));
    }

    public function login(Request $request, string $token)
    {
        $diklat = MDiklat::where('QRcode', $token)
            ->where('IsActive', 1)
            ->firstOrFail();

        $request->validate([
            'nip'      => 'required|string',
            'password' => 'required|string',
        ], [
            'nip.required'      => 'NIK/NIP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('nip', $request->nip)
            ->where('isActive', 1)
            ->first();

        if (!$user) {
            $user = User::where('email', $request->nip)
                ->where('isActive', 1)
                ->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['nip' => 'NIK/Email atau password salah.'])->withInput();
        }

        return $this->prosesAbsensi($user, $diklat);
    }

    // Absen langsung dari sesi yang sudah login — tanpa form
    public function confirm(string $token)
    {
        $diklat = MDiklat::where('QRcode', $token)
            ->where('IsActive', 1)
            ->firstOrFail();

        if (!Auth::check()) {
            return redirect()->route('absensi.scan', $token);
        }

        $user = Auth::user();
        return $this->prosesAbsensi($user, $diklat);
    }

    private function prosesAbsensi(User $user, MDiklat $diklat)
    {
        $record = RecordAbsensiDiklat::where('id_diklat', $diklat->id)
            ->where('id_user', $user->id)
            ->first();

        Auth::login($user);

        if ($record && $record->is_hadir) {
            return view('absensi.scan-result', [
                'status'  => 'warning',
                'message' => 'Anda sudah tercatat hadir di acara ini.',
                'diklat'  => $diklat,
                'user'    => $user,
            ]);
        }

        $hadir = RecordAbsensiDiklat::where('id_diklat', $diklat->id)
            ->where('is_hadir', true)
            ->count();

        if ($hadir >= $diklat->kuota) {
            return view('absensi.scan-result', [
                'status'  => 'error',
                'message' => 'Kuota acara sudah penuh.',
                'diklat'  => $diklat,
                'user'    => $user,
            ]);
        }

        if ($record) {
            $record->update([
                'is_hadir' => true,
                'durasi'   => $diklat->durasi * 60,
                'date'     => now(),
            ]);
        } else {
            RecordAbsensiDiklat::create([
                'id_diklat'   => $diklat->id,
                'id_user'     => $user->id,
                'namaPeserta' => $user->nama,
                'durasi'      => $diklat->durasi * 60,
                'date'        => now(),
                'is_hadir'    => true,
            ]);
        }

        return view('absensi.scan-result', [
            'status'  => 'success',
            'message' => 'Absensi berhasil dicatat!',
            'diklat'  => $diklat,
            'user'    => $user,
        ]);
    }
}