<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PenawaranTbs;
use App\Models\PenjualanPetaniKePengepul;
use App\Models\PenimbanganPengepul;

class PenimbanganPengepulController extends Controller
{
    public function index()
    {
        $pengepulId = Auth::id();

        // 1️⃣ Ambil penawaran TBS yang masih reserved
        $penawaranTbs = PenawaranTbs::where('status', 'reserved')
            ->where('reserved_by_pengepul_id', $pengepulId)
            ->with('petani')
            ->get();

        // 2️⃣ Ambil penjualan petani ke pengepul yang masih accepted
        $penjualan = PenjualanPetaniKePengepul::where('status', 'accepted')
            ->where('pengepul_id', $pengepulId)
            ->with('petani')
            ->get();

        // 3️⃣ Gabungkan keduanya menjadi satu collection
        $penawaran = $penawaranTbs->concat($penjualan);

        return view('pengepul.penimbangan.index', compact('penawaran'));
    }

    public function store(Request $request)
    {
        $rules = [
            'tbs_baik_kg' => 'required|numeric|min:0',
            'harga_baik_per_kg' => 'required|numeric|min:0',
            'tbs_reject_kg' => 'nullable|numeric|min:0',
            'harga_reject_per_kg' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
        ];
    
        // Tentukan sumber
        if ($request->filled('penawaran_tbs_id')) {
            $rules['penawaran_tbs_id'] = 'required|exists:penawaran_tbs,id';
        } elseif ($request->filled('penjualan_id')) {
            $rules['penjualan_id'] = 'required|exists:penjualan_petani_ke_pengepul,id';
        } else {
            return redirect()->back()->with('error', 'Sumber penimbangan tidak valid.');
        }
    
        $validated = $request->validate($rules);
    
        // Hitung total
        $validated['total_baik'] = $validated['tbs_baik_kg'] * $validated['harga_baik_per_kg'];
        $validated['total_reject'] = ($validated['tbs_reject_kg'] ?? 0) * ($validated['harga_reject_per_kg'] ?? 0);
        $validated['tanggal_penimbangan'] = now();
    
        // Simpan
        $penimbangan = \App\Models\PenimbanganPengepul::create($validated);
    
        // Update status
        if (isset($validated['penawaran_tbs_id'])) {
            $penawaran = \App\Models\PenawaranTbs::find($validated['penawaran_tbs_id']);
            $penawaran->update(['status' => 'finish']);
        } else {
            $penjualan = \App\Models\PenjualanPetaniKePengepul::find($validated['penjualan_id']);
            $penjualan->update(['status' => 'finish']);
        }
    
        return redirect()->back()->with('success', 'Data penimbangan berhasil disimpan.');
    }
    
}
