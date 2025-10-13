<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;

class PenimbanganPengepulController extends Controller
{
    /**
     * Tampilkan semua pembelian yang masih on_progress
     */
    public function index()
    {
        $pembelians = Pembelian::with(['penjualan.petani'])
            ->where('status', 'on_progress')
            ->latest()
            ->get();

        return view('pengepul.penimbangan.index', compact('pembelians'));
    }

    /**
     * Update hasil penimbangan dan selesaikan transaksi
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_kg' => 'required|numeric|min:1',
            'harga_perkg' => 'required|numeric|min:1',
            'kualitas' => 'required|string',
        ]);

        $pembelian = Pembelian::findOrFail($id);

        $totalHarga = $request->jumlah_kg * $request->harga_perkg;

        $pembelian->update([
            'jumlah_kg' => $request->jumlah_kg,
            'harga_perkg' => $request->harga_perkg,
            'total_harga' => $totalHarga,
            'kualitas' => $request->kualitas,
            'status' => 'selesai',
        ]);

        // Ubah status penjualan menjadi selesai
        $pembelian->penjualan->update(['status' => 'finished']);

        return back()->with('success', 'Data penimbangan berhasil disimpan dan transaksi selesai.');
    }
}
