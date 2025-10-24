<?php

namespace App\Http\Controllers;

use App\Models\PenimbanganPks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatTransaksiPksController extends Controller
{
    public function index()
    {
        $pksId = Auth::id();

        // Ambil semua penimbangan milik PKS yang sedang login + relasi ke pengepul
        $transaksi = PenimbanganPks::with(['penawaran.pengepul'])
            ->whereHas('penawaran', function ($query) use ($pksId) {
                $query->where('pks_id', $pksId);
            })
            ->orderBy('tanggal_penerimaan', 'asc')
            ->get();

        // Siapkan data untuk grafik line (total transaksi per bulan)
        $chartData = $transaksi->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->tanggal_penerimaan)->format('Y-m');
        })->map(function ($group) {
            return $group->sum('total_transaksi');
        });

        $chartLabels = $chartData->keys();
        $chartValues = $chartData->values();

        return view('pks.riwayattransaksi.index', compact('transaksi', 'chartLabels', 'chartValues'));
    }
}
