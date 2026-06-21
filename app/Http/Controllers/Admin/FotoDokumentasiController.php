<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MDiklat;
use App\Models\MFileDiklat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoDokumentasiController extends Controller
{
    public function upload(Request $request, MDiklat $diklat)
    {
        $request->validate([
            'fotos'   => 'required|array|min:1|max:20',
            'fotos.*' => 'image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $count  = 0;
        $folder = 'dokumentasi/' . $diklat->id;

        foreach ($request->file('fotos') as $foto) {
            $path = $foto->store($folder, 'public');

            MFileDiklat::create([
                'id_diklat'  => $diklat->id,
                'file'       => $path,
                'type'       => 'foto',
                'created_by' => auth()->id(),
            ]);

            $count++;
        }

        return back()->with('success', "{$count} foto berhasil diupload.");
    }

    public function hapus(MDiklat $diklat, MFileDiklat $foto)
    {
        Storage::disk('public')->delete($foto->file);
        $foto->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
