<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MDiklat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AcaraSampulController extends Controller
{
    public function upload(Request $request, MDiklat $diklat)
    {
        $request->validate([
            'sampul' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($diklat->img) {
            Storage::disk('public')->delete($diklat->img);
        }

        $path = $request->file('sampul')->store('sampul', 'public');
        $diklat->update(['img' => $path]);

        return back()->with('success', 'Gambar sampul berhasil diupload.');
    }

    public function hapus(MDiklat $diklat)
    {
        if ($diklat->img) {
            Storage::disk('public')->delete($diklat->img);
            $diklat->update(['img' => null]);
        }
        return back()->with('success', 'Gambar sampul berhasil dihapus.');
    }
}