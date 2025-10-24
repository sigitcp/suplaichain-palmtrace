<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProfilPengepul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilPengepulController extends Controller
{
    /**
     * Menampilkan semua user dengan role = 3 (pengepul)
     */
    public function index()
    {
        $pengepul = User::where('role_id', 3)->get();

        return view('admin.pengepul.index', compact('pengepul'));
    }



    public function kelolaProfil($id)
    {
        $user = User::findOrFail($id);
        $profil = ProfilPengepul::where('user_id', $id)->first();

        return view('admin.pengepul.profil.index', compact('user', 'profil'));
    }

    public function storeOrUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_koperasi' => 'required|string|max:255',
            'kapasitas_tbs' => 'required|numeric',
            'sertifikat_koperasi' => 'nullable|file|mimes:pdf|max:2048',
            'alamat' => 'required|string|max:500',
            'gmap_link' => 'nullable|url',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto_kantor' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $profil = ProfilPengepul::where('user_id', $id)->first();
        $validated['user_id'] = $id;
    
        // === Handle sertifikat koperasi ===
        if ($request->hasFile('sertifikat_koperasi')) {
            // Hapus file lama jika ada
            if ($profil && $profil->sertifikat_koperasi && Storage::disk('public')->exists($profil->sertifikat_koperasi)) {
                Storage::disk('public')->delete($profil->sertifikat_koperasi);
            }
    
            // Upload file baru ke folder public/sertifikat_koperasi
            $validated['sertifikat_koperasi'] = $request->file('sertifikat_koperasi')->store('sertifikat_koperasi', 'public');
        } else {
            // Jika tidak upload file baru, pertahankan file lama
            if ($profil) {
                $validated['sertifikat_koperasi'] = $profil->sertifikat_koperasi;
            }
        }
    
        // === Handle foto kantor ===
        if ($request->hasFile('foto_kantor')) {
            // Hapus foto lama jika ada
            if ($profil && $profil->foto_kantor && Storage::disk('public')->exists($profil->foto_kantor)) {
                Storage::disk('public')->delete($profil->foto_kantor);
            }
    
            // Upload foto baru ke folder public/foto_kantor
            $validated['foto_kantor'] = $request->file('foto_kantor')->store('foto_kantor', 'public');
        } else {
            // Jika tidak upload foto baru, pertahankan foto lama
            if ($profil) {
                $validated['foto_kantor'] = $profil->foto_kantor;
            }
        }
    
        // === Simpan atau update data ===
        if ($profil) {
            $profil->update($validated);
            return redirect()->back()->with('success', 'Profil pengepul berhasil diperbarui.');
        } else {
            ProfilPengepul::create($validated);
            return redirect()->back()->with('success', 'Profil pengepul berhasil ditambahkan.');
        }
    }

}
