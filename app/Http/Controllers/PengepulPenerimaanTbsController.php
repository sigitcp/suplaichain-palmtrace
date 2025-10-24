<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PembukaanPenerimaanPengepul;
use App\Models\PenjualanPetaniKePengepul;

class PengepulPenerimaanTbsController extends Controller
{
    // Halaman utama pengepul
    public function index()
    {
        $pengepulId = Auth::id();

        // NOTE: kolom di tabel migration adalah "pengepul_user_id"
        // bukan "pengepul_id" — jadi kita pakai pengepul_user_id di query
        $penerimaan = PembukaanPenerimaanPengepul::where('pengepul_user_id', $pengepulId)
            ->latest()
            ->first();

        // Ambil semua penawaran petani untuk penerimaan ini
        $penawaranPetani = $penerimaan
            ? PenjualanPetaniKePengepul::with('petani')
                ->where('pembukaan_penerimaan_id', $penerimaan->id)
                ->orderBy('created_at', 'desc')
                ->get()
            : collect();

        return view('pengepul.penerimaantbs.index', compact('penerimaan', 'penawaranPetani'));
    }

    // Membuka penerimaan baru
    public function store(Request $request)
    {
        $request->validate([
            'harga_per_kg' => 'required|numeric|min:1',
            'kapasitas_kg' => 'nullable|numeric|min:1',
            'terms' => 'nullable|string',
        ]);

        $pengepulId = Auth::id();

        // Tutup penerimaan lama (jika ada)
        PembukaanPenerimaanPengepul::where('pengepul_user_id', $pengepulId)->update(['status' => 'closed']);

        // Buat penerimaan baru (perhatikan kolom pengepul_user_id)
        PembukaanPenerimaanPengepul::create([
            'pengepul_user_id' => $pengepulId,
            'harga_per_kg' => $request->harga_per_kg,
            'kapasitas_kg' => $request->kapasitas_kg,
            'terms' => $request->terms,
            'status' => 'open',
        ]);

        return redirect()->route('pengepul.penerimaantbs.index')->with('success', 'Penerimaan TBS berhasil dibuka!');
    }

    // Toggle status buka/tutup
    public function toggle()
    {
        $pengepulId = Auth::id();
        $penerimaan = PembukaanPenerimaanPengepul::where('pengepul_user_id', $pengepulId)->latest()->first();

        if (!$penerimaan) {
            return redirect()->back()->with('error', 'Belum ada data penerimaan untuk diubah.');
        }

        $penerimaan->status = $penerimaan->status == 'open' ? 'closed' : 'open';
        $penerimaan->save();

        $msg = $penerimaan->status == 'open' ? 'Penerimaan dibuka kembali.' : 'Penerimaan ditutup.';
        return redirect()->back()->with('success', $msg);
    }

    // Konfirmasi penawaran petani
    public function konfirmasi(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:accepted,rejected,finish',
        'tanggal_penjemputan' => 'nullable|date',
        'nomor_armada_penjemputan' => 'nullable|string|max:50',
    ]);

    $penawaran = PenjualanPetaniKePengepul::findOrFail($id);
    $penawaran->status = $request->status;

    // Jika status diterima dan ada data penjemputan, simpan
    if ($request->status === 'accepted' && $penawaran->is_pickup) {
        $penawaran->tanggal_penjemputan = $request->tanggal_penjemputan;
        $penawaran->nomor_armada_penjemputan = $request->nomor_armada_penjemputan;
    }

    $penawaran->save();

    return redirect()->back()->with('success', 'Status penawaran berhasil diperbarui.');
}

}
