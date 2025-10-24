<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProfilPetani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilPetaniController extends Controller
{
    /**
     * Tampilkan daftar seluruh user dengan role petani.
     */
    public function index()
    {
        $petani = User::whereHas('role', function ($q) {
            $q->where('name', 'petani');
        })->get();

        return view('admin.petani.profil.index', compact('petani'));
    }

    /**
     * Tampilkan halaman kelola profil petani.
     */
    public function kelola($id)
    {
        $user = User::findOrFail($id);
        $profil = ProfilPetani::where('user_id', $id)->first();

        return view('admin.petani.profil.kelola.index', compact('user', 'profil'));
    }

    /**
     * Simpan atau update profil petani.
     */
    public function storeOrUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_petani' => 'required|string|max:255',
            'varietas_bibit' => 'nullable|string|max:255',
            'luasan_lahan_total' => 'nullable|numeric',
            'alamat' => 'required|string|max:500',
            'gmap_link' => 'nullable|url',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $profil = ProfilPetani::updateOrCreate(
            ['user_id' => $id],
            [
                'nama_petani' => $request->nama_petani,
                'varietas_bibit' => $request->varietas_bibit,
                'luasan_lahan_total' => $request->luasan_lahan_total,
                'alamat' => $request->alamat,
                'gmap_link' => $request->gmap_link,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]
        );

        return redirect()->route('kelola-profil-petani', $id)
                         ->with('success', 'Profil petani berhasil disimpan.');
    }
}
