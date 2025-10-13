<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lahan;
use App\Models\DetailLahan;
use App\Models\Panen;

class KebunPetaniController extends Controller
{
    public function index($id)
    {
        // Pastikan petani hanya bisa melihat lahannya sendiri
        $lahan = Lahan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    
        // Ambil detail lahan jika ada
        $detail = DetailLahan::where('lahan_id', $lahan->id)->first();
    
        // Ambil data panen berdasarkan lahan
        $panens = Panen::where('lahan_id', $lahan->id)
            ->orderBy('tanggal_panen', 'desc')
            ->get();
    
        // ==========================
        // Hitung Data Summary Panen
        // ==========================
    
        // Total panen = jumlah semua jumlah_pokok
        $totalPanen = $panens->sum('jumlah_pokok');
    
        // Rata-rata panen per hari = rata-rata jumlah_pokok
        $rataRataPanen = $panens->count() > 0 ? round($panens->avg('jumlah_pokok'), 2) : 0;
    
        // Panen terakhir = data terakhir (tanggal dan jumlah_pokok)
        $panenTerakhir = $panens->first(); // karena sudah diurutkan DESC
    
        // Hari panen aktif = jumlah data panen yang dimasukkan
        $hariPanenAktif = $panens->count();
    
        // Panen tertinggi = data dengan jumlah_pokok terbesar
        $panenTertinggi = $panens->sortByDesc('jumlah_pokok')->first();
    
        return view('petani.monitoring.index', compact(
            'lahan',
            'detail',
            'panens',
            'totalPanen',
            'rataRataPanen',
            'panenTerakhir',
            'hariPanenAktif',
            'panenTertinggi'
        ));
    } 

    public function storePanen(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal_panen' => 'required|date',
            'jumlah_pokok' => 'required|numeric|min:1',
            'jumlah_perpokok' => 'required|numeric|min:0',
            'kualitas' => 'required|in:baik,cukup,unggul',
        ]);

        $lahan = Lahan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated['lahan_id'] = $lahan->id;

        Panen::create($validated);

        return redirect()->back()->with('success', 'Data panen berhasil ditambahkan.');
    }

    public function updatePanen(Request $request, $id, $panenId)
    {
        $validated = $request->validate([
            'tanggal_panen' => 'required|date',
            'jumlah_pokok' => 'required|numeric|min:1',
            'jumlah_perpokok' => 'required|numeric|min:0',
            'kualitas' => 'required|in:baik,cukup,unggul',
        ]);

        // Pastikan hanya lahan milik petani ini yang bisa diubah
        $lahan = Lahan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $panen = Panen::where('id', $panenId)
            ->where('lahan_id', $lahan->id)
            ->firstOrFail();

        $panen->update($validated);

        return redirect()->back()->with('success', 'Data panen berhasil diperbarui.');
    }

    public function deletePanen($id, $panenId)
    {
        // Pastikan hanya lahan milik petani yang bisa dihapus
        $lahan = Lahan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $panen = Panen::where('id', $panenId)
            ->where('lahan_id', $lahan->id)
            ->firstOrFail();

        $panen->delete();

        return redirect()->back()->with('success', 'Data panen berhasil dihapus.');
    }
}
