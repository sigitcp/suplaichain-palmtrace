<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lahan;
use App\Models\DetailLahan;
use Illuminate\Support\Facades\Storage;

class LahanController extends Controller
{
    // Tampilkan semua user role petani
    public function index()
    {
        $petani = User::where('role_id', 2)->get();
        return view('admin.petani.index', compact('petani'));
    }

    // Kelola lahan milik petani tertentu
    public function kelolaLahan($userId)
    {
        $petani = User::where('role_id', 2)->findOrFail($userId);

        $lahans = Lahan::where('user_id', $petani->id)->get();

        return view('admin.petani.lahan.index', compact('petani', 'lahans'));
    }

    // Simpan lahan baru
    public function storeLahan(Request $request, $userId)
    {
        $petani = User::where('role_id', 2)->findOrFail($userId);

        $request->validate([
            'nama_lahan' => 'required|string|max:255|unique:lahans,nama_lahan,NULL,id,user_id,' . $petani->id,
            'alamat'     => 'nullable|string|max:500',
            'gmaps_link' => 'nullable|url',
        ], [
            'nama_lahan.unique' => 'Nama lahan ini sudah terdaftar untuk petani ini.',
            'nama_lahan.required' => 'Nama lahan wajib diisi.',
            'gmaps_link.url' => 'Format link Google Maps tidak valid.',
        ]);

        Lahan::create([
            'user_id'    => $petani->id,
            'nama_lahan' => $request->nama_lahan,
            'alamat'     => $request->alamat,
            'gmaps_link' => $request->gmaps_link,
        ]);

        return redirect()->route('kelola-lahan', ['userId' => $petani->id])
            ->with('success', 'Lahan berhasil ditambahkan.');
    }


    // Update lahan
    public function updateLahan(Request $request, $id)
    {
        // Cari data lahan berdasarkan ID
        $lahan = Lahan::findOrFail($id);

        // Validasi input
        $request->validate([
            'nama_lahan' => 'required|string|max:255|unique:lahans,nama_lahan,' . $lahan->id . ',id,user_id,' . $lahan->user_id,
            'alamat'     => 'required|string|max:500',
            'gmaps_link' => 'nullable|url',
        ], [
            'nama_lahan.required' => 'Nama lahan wajib diisi.',
            'nama_lahan.unique'   => 'Nama lahan ini sudah terdaftar untuk petani tersebut.',
            'alamat.required'     => 'Alamat wajib diisi.',
            'gmaps_link.url'      => 'Format link Google Maps tidak valid.',
        ]);

        // Update data
        $lahan->update([
            'nama_lahan' => $request->nama_lahan,
            'alamat'     => $request->alamat,
            'gmaps_link' => $request->gmaps_link,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data lahan berhasil diperbarui.');
    }


    // Hapus lahan
    public function destroyLahan(Request $request, $id)
    {
        $lahan = Lahan::findOrFail($id);

        // Validasi: pastikan nama lahan yang diketik sama dengan yang terdaftar
        if ($request->input('nama_lahan') !== $lahan->nama_lahan) {
            return redirect()->back()->with('error', 'Nama lahan tidak cocok. Penghapusan dibatalkan.');
        }

        // Hapus data lahan
        $lahan->delete();

        return redirect()->back()->with('success', 'Data lahan berhasil dihapus secara permanen.');
    }







    public function kelolaDetailLahan($lahanId)
    {
        // Ambil data lahan berdasarkan ID
        $lahan = Lahan::with('user')->findOrFail($lahanId);

        // Ambil detail lahan (jika sudah ada)
        $detail = DetailLahan::where('lahan_id', $lahanId)->first();

        return view('admin.petani.lahan.detaillahan.index', compact('lahan', 'detail'));
    }



    
    public function simpanAtauUpdateDetailLahan(Request $request, $lahanId)
    {
        $lahan = Lahan::findOrFail($lahanId);

        $request->validate([
            'penanggung_jawab' => 'required|string|max:255',
            'luas_kebun'       => 'required|numeric',
            'sertifikat'       => 'nullable|mimes:pdf|max:5120', // maks 5MB
            'file_geojson'     => 'nullable|file|mimes:json,geojson|max:10240', // maks 10MB
        ]);

        // Cari apakah sudah ada detail lahan
        $detail = DetailLahan::where('lahan_id', $lahan->id)->first();

        // Simpan file sertifikat (kalau diupload)
        $sertifikatPath = $detail->sertifikat ?? null;
        if ($request->hasFile('sertifikat')) {
            if ($sertifikatPath && Storage::disk('public')->exists($sertifikatPath)) {
                Storage::disk('public')->delete($sertifikatPath);
            }
            $sertifikatPath = $request->file('sertifikat')->store('uploads/sertifikat', 'public');
        }

        // Simpan file geojson (kalau diupload)
        $geojsonPath = $detail->file_geojson ?? null;
        if ($request->hasFile('file_geojson')) {
            if ($geojsonPath && Storage::disk('public')->exists($geojsonPath)) {
                Storage::disk('public')->delete($geojsonPath);
            }
            $geojsonPath = $request->file('file_geojson')->store('uploads/geojson', 'public');
        }

        // Jika sudah ada detail → update
        if ($detail) {
            $detail->update([
                'penanggung_jawab' => $request->penanggung_jawab,
                'luas_kebun'       => $request->luas_kebun,
                'sertifikat'       => $sertifikatPath,
                'file_geojson'     => $geojsonPath,
            ]);
            $pesan = 'Detail lahan berhasil diperbarui.';
        } else {
            // Jika belum ada → buat baru
            DetailLahan::create([
                'lahan_id'         => $lahan->id,
                'penanggung_jawab' => $request->penanggung_jawab,
                'luas_kebun'       => $request->luas_kebun,
                'sertifikat'       => $sertifikatPath,
                'file_geojson'     => $geojsonPath,
            ]);
            $pesan = 'Detail lahan berhasil ditambahkan.';
        }

        return redirect()->route('kelola-detail-lahan', ['lahanId' => $lahan->id])
            ->with('success', $pesan);
    }
}
