<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PembukaanPenerimaanPks;
use App\Models\PenawaranPengepulKePks;

class PksPenerimaanTbsController extends Controller
{
    // Halaman utama PKS
    public function index()
    {
        $pksId = Auth::id();

        // Ambil penerimaan PKS terakhir
        $penerimaan = PembukaanPenerimaanPks::where('pks_user_id', $pksId)
            ->latest()
            ->first();

        // Ambil semua penawaran pengepul untuk penerimaan ini
        $penawaranPengepul = $penerimaan
            ? PenawaranPengepulKePks::with('pengepul')
                ->where('pks_id', $pksId)
                ->orderBy('created_at', 'desc')
                ->get()
            : collect();

        return view('pks.penerimaantbs.index', compact('penerimaan', 'penawaranPengepul'));
    }

    // Membuka penerimaan baru
    public function store(Request $request)
    {
        $request->validate([
            'harga_per_kg' => 'required|numeric|min:1',
            'kapasitas_kg' => 'nullable|numeric|min:1',
            'terms' => 'nullable|string',
        ]);

        $pksId = Auth::id();

        // Tutup penerimaan lama (jika ada)
        PembukaanPenerimaanPks::where('pks_user_id', $pksId)->update(['status' => 'closed']);

        // Buat penerimaan baru
        PembukaanPenerimaanPks::create([
            'pks_user_id' => $pksId,
            'harga_per_kg' => $request->harga_per_kg,
            'kapasitas_kg' => $request->kapasitas_kg,
            'terms' => $request->terms,
            'status' => 'open',
        ]);

        return redirect()->route('pks.penerimaantbs.index')->with('success', 'Penerimaan TBS berhasil dibuka!');
    }

    // Toggle buka/tutup penerimaan
    public function toggle()
    {
        $pksId = Auth::id();
        $penerimaan = PembukaanPenerimaanPks::where('pks_user_id', $pksId)->latest()->first();

        if (!$penerimaan) {
            return redirect()->back()->with('error', 'Belum ada penerimaan untuk diubah.');
        }

        $penerimaan->status = $penerimaan->status == 'open' ? 'closed' : 'open';
        $penerimaan->save();

        $msg = $penerimaan->status == 'open' ? 'Penerimaan dibuka kembali.' : 'Penerimaan ditutup.';
        return redirect()->back()->with('success', $msg);
    }

    // Konfirmasi penawaran pengepul (Terima / Tolak)
    public function konfirmasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $penawaran = PenawaranPengepulKePks::findOrFail($id);
        $penawaran->status = $request->status;
        $penawaran->save();

        return redirect()->back()->with('success', 'Status penawaran berhasil diperbarui.');
    }
}
