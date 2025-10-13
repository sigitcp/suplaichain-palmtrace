<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Models\Penjualan;
use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiPetaniController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $lahanIds = Lahan::where('user_id', $userId)->pluck('id');
        $totalPanen = Panen::whereIn('lahan_id', $lahanIds)->sum('jumlah_pokok');

        $penjualanAktif = Penjualan::where('petani_id', $userId)
            ->whereIn('status', ['waiting', 'accepted'])
            ->exists();

        $tampilPanen = $penjualanAktif ? 0 : $totalPanen;

        $penjualans = Penjualan::where('petani_id', $userId)
            ->with(['pembelian.pengepul'])
            ->latest()
            ->get();

        return view('petani.transaksi.index', compact('tampilPanen', 'penjualans', 'penjualanAktif'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        // 🔹 Cek apakah masih ada penjualan aktif
        $adaPenjualanAktif = Penjualan::where('petani_id', $userId)
            ->whereIn('status', ['waiting', 'accepted'])
            ->exists();

        if ($adaPenjualanAktif) {
            return back()->with('error', 'Penjualan sebelumnya belum selesai. Silakan tunggu hingga transaksi selesai.');
        }

        // 🔹 Ambil semua ID lahan milik petani
        $lahanIds = Lahan::where('user_id', $userId)->pluck('id');

        // 🔹 Hitung total panen
        $totalPanen = Panen::whereIn('lahan_id', $lahanIds)->sum('jumlah_pokok');

        if ($totalPanen <= 0) {
            return back()->with('error', 'Belum ada hasil panen untuk dijual.');
        }

        // 🔹 Ambil panen terbaru untuk dijual
        $panen = Panen::whereIn('lahan_id', $lahanIds)->latest()->first();

        if (!$panen) {
            return back()->with('error', 'Data panen tidak ditemukan.');
        }

        // 🔹 Buat penjualan baru
        Penjualan::create([
            'petani_id' => $userId,
            'panen_id' => $panen->id,
            'status' => 'waiting',
        ]);

        return back()->with('success', '✅ Penjualan berhasil dibuat. Menunggu pengepul melakukan pembelian.');
    }
}
