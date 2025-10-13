<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiPengepulController extends Controller
{
    // Tampilkan semua penjualan dengan status waiting
    public function index()
{
    $penjualans = Penjualan::with('petani')
        ->where('status', 'waiting')
        ->latest()
        ->get();

    $riwayatPembelian = Pembelian::with(['penjualan.petani'])
        ->where('pengepul_id', Auth::id())
        ->latest()
        ->get();

    return view('pengepul.transaksi.index', compact('penjualans', 'riwayatPembelian'));
}


    // Tahap 1 — Input awal: nomor armada & tanggal jemput
    public function store(Request $request, $id)
    {
        $request->validate([
            'nomor_armada' => 'required|string',
            'tanggal_jemput' => 'required|date',
        ]);

        $penjualan = Penjualan::findOrFail($id);

        // 🔒 Validasi: Jika sudah dibeli oleh pengepul lain, tolak
        if ($penjualan->status !== 'waiting') {
            return back()->with('error', 'Penjualan ini sudah diambil oleh pengepul lain.');
        }

        // Buat pembelian awal
        Pembelian::create([
            'penjualan_id' => $penjualan->id,
            'pengepul_id' => Auth::id(),
            'nomor_armada' => $request->nomor_armada,
            'tanggal_jemput' => $request->tanggal_jemput,
            'status' => 'on_progress',
        ]);

        // Update status penjualan menjadi accepted
        $penjualan->update(['status' => 'accepted']);

        return back()->with('success', 'Pembelian telah dicatat, menunggu pengambilan.');
    }

    // Tahap 2 — Update data setelah penjemputan
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

        return back()->with('success', 'Transaksi berhasil diselesaikan.');
    }
}
