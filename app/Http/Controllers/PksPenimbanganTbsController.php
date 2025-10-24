<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PenawaranPengepulKePks;
use App\Models\PenimbanganPks;

class PksPenimbanganTbsController extends Controller
{
    // Halaman daftar penimbangan PKS
    public function index()
    {
        $pksId = Auth::id();

        // Ambil semua penawaran yang sudah diterima dan belum selesai ditimbang
        $penawaran = PenawaranPengepulKePks::where('pks_id', $pksId)
                        ->where('status', 'accepted')
                        ->with('pengepul')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('pks.penimbangantbs.index', compact('penawaran'));
    }

    // Simpan data penimbangan PKS
    public function store(Request $request)
    {
        $request->validate([
            'penawaran_pengepul_id' => 'required|exists:penawaran_pengepul_ke_pks,id',
            'tanggal_penerimaan' => 'required|date',
            'bruto' => 'required|numeric|min:0',
            'tara' => 'required|numeric|min:0',
            'netto' => 'required|numeric|min:0',
            'harga_beli_per_kg' => 'required|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
            'total_transaksi' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        $penimbangan = PenimbanganPks::create([
            'penawaran_pengepul_id' => $request->penawaran_pengepul_id,
            'tanggal_penerimaan' => $request->tanggal_penerimaan,
            'bruto' => $request->bruto,
            'tara' => $request->tara,
            'netto' => $request->netto,
            'harga_beli_per_kg' => $request->harga_beli_per_kg,
            'potongan' => $request->potongan ?? 0,
            'total_transaksi' => $request->total_transaksi,
            'catatan' => $request->catatan,
        ]);

        // Update status penawaran menjadi 'completed'
        $penawaran = PenawaranPengepulKePks::find($request->penawaran_pengepul_id);
        $penawaran->status = 'completed';
        $penawaran->save();

        return redirect()->back()->with('success', 'Penimbangan TBS berhasil disimpan.');
    }
}
