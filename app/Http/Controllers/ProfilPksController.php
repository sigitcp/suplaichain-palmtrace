<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProfilPks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilPksController extends Controller
{
    public function index()
    {
        $pks = User::whereHas('role', function ($q) {
            $q->where('name', 'pks');
        })->get();

        return view('admin.pks.index', compact('pks'));
    }

    public function kelola($id)
    {
        $user = User::findOrFail($id);
        $profil = ProfilPks::where('user_id', $id)->first();

        return view('admin.pks.profil.index', compact('user', 'profil'));
    }

    public function storeOrUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_pks' => 'required|string|max:255',
            'kapasitas_tbs_kg' => 'nullable|numeric',
            'alamat' => 'required|string|max:500',
            'gmap_link' => 'nullable|url',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto_kantor' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'nama_pks' => $request->nama_pks,
            'kapasitas_tbs_kg' => $request->kapasitas_tbs_kg,
            'alamat' => $request->alamat,
            'gmap_link' => $request->gmap_link,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];

        if ($request->hasFile('foto_kantor')) {
            // Simpan di storage/app/public/kantorpks/
            $path = $request->file('foto_kantor')->store('kantorpks', 'public');
            $data['foto_kantor'] = $path;
        }

        ProfilPks::updateOrCreate(['user_id' => $id], $data);

        return redirect()->route('kelola-profil-pks', $id)
                         ->with('success', 'Profil PKS berhasil disimpan.');
    }

    public function showPhoto($filename)
    {
        $path = storage_path('app/public/kantorpks/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
