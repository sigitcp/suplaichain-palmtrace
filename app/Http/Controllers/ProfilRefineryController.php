<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProfilRefinery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilRefineryController extends Controller
{
    /**
     * Tampilkan daftar seluruh user dengan role refinery.
     */
    public function index()
    {
        $refinery = User::whereHas('role', function ($q) {
            $q->where('name', 'refinery');
        })->get();

        return view('admin.refinery.index', compact('refinery'));
    }

    /**
     * Tampilkan halaman kelola profil refinery.
     */
    public function kelola($id)
    {
        $user = User::findOrFail($id);
        $profil = ProfilRefinery::where('user_id', $id)->first();

        return view('admin.refinery.profil.index', compact('user', 'profil'));
    }

    /**
     * Simpan atau update profil refinery.
     */
    public function storeOrUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_refinery' => 'required|string|max:255',
            'kapasitas_tbs_kg' => 'nullable|numeric',
            'alamat' => 'required|string|max:500',
            'gmap_link' => 'nullable|url',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto_kantor' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'nama_refinery' => $request->nama_refinery,
            'kapasitas_tbs_kg' => $request->kapasitas_tbs_kg,
            'alamat' => $request->alamat,
            'gmap_link' => $request->gmap_link,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];

        if ($request->hasFile('foto_kantor')) {
            // simpan di storage/app/public/refinery/
            $path = $request->file('foto_kantor')->store('refinery', 'public');
            $data['foto_kantor'] = $path;
        }

        ProfilRefinery::updateOrCreate(['user_id' => $id], $data);

        return redirect()->route('kelola-profil-refinery', $id)
                         ->with('success', 'Profil Refinery berhasil disimpan.');
    }

    /**
     * Menampilkan foto kantor refinery.
     */
    public function showPhoto($filename)
    {
        $path = storage_path('app/public/refinery/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
