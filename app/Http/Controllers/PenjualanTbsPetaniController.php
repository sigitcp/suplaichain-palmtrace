<?php

namespace App\Http\Controllers;

use App\Models\PembukaanPenerimaanPengepul;
use App\Models\PenjualanPetaniKePengepul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualanTbsPetaniController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
    
        // Ambil penerimaan pengepul yang belum diikuti oleh petani
        $penerimaanTerbuka = \App\Models\PembukaanPenerimaanPengepul::with('pengepul')
            ->where('status', 'open')
            ->whereNotIn('id', function ($q) use ($userId) {
                $q->select('pembukaan_penerimaan_id')
                  ->from('penjualan_petani_ke_pengepul')
                  ->where('petani_id', $userId);
            })
            ->latest()
            ->get();
    
        // Ambil penawaran yang sudah dikirim petani
        $penawaranSaya = \App\Models\PenjualanPetaniKePengepul::with(['pengepul', 'penerimaanPengepul'])
            ->where('petani_id', $userId)
            ->latest()
            ->get();
    
        return view('petani.permintaantbs.index', compact('penerimaanTerbuka', 'penawaranSaya'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'pembukaan_penerimaan_id' => 'required|exists:pembukaan_penerimaan_pengepul,id',
            'estimasi_tbs_kg' => 'required|numeric|min:1',
            'is_pickup' => 'required|boolean',
            'tanggal_pengantaran' => 'nullable|date',
            'nomor_armada_pengantaran' => 'nullable|string|max:50',
        ]);

        $penerimaan = PembukaanPenerimaanPengepul::findOrFail($request->pembukaan_penerimaan_id);

        // Jika metode jemput, tanggal antar diabaikan
        $tanggalAntar = $request->is_pickup ? null : $request->tanggal_pengantaran;
        $armadaAntar = $request->is_pickup ? null : $request->nomor_armada_pengantaran;

        PenjualanPetaniKePengepul::create([
            'petani_id' => Auth::id(),
            'pengepul_id' => $penerimaan->pengepul_user_id,
            'pembukaan_penerimaan_id' => $penerimaan->id,
            'estimasi_tbs_kg' => $request->estimasi_tbs_kg,
            'is_pickup' => $request->is_pickup,
            'tanggal_pengantaran' => $tanggalAntar,
            'nomor_armada_pengantaran' => $armadaAntar,
            'status' => 'pending',
        ]);

        return redirect()->route('petani.permintaantbs.index')
            ->with('success', 'Penawaran TBS berhasil dikirim ke pengepul.');
    }
}
