<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Helpers\AuthHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        // Block user yang belum aktif (pending approval)
        if (!$user->isActive) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun Anda belum diaktifkan. Silakan tunggu persetujuan admin.',
            ]);
        }

        // Ambil tujuan semula SEBELUM regenerate (kalau datang dari scan QR absen)
        $intended = $request->session()->pull('url.intended');
        $request->session()->regenerate();

        // Hanya kembali ke halaman scan absen; selain itu ikut alur role biasa
        if ($intended && str_contains($intended, '/absensi/scan/')) {
            return redirect($intended);
        }

        return redirect(AuthHelper::redirectByRole());
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}