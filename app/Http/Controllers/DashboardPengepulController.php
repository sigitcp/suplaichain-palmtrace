<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PenimbanganPengepul;
use App\Models\PenimbanganPks;
use App\Models\HargaTbsMingguan;

class DashboardPengepulController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // === Jumlah laporan masuk (penimbangan dari petani ke pengepul) ===
        $laporanMasuk = PenimbanganPengepul::whereHas('penawaran', function ($q) use ($userId) {
            $q->where('reserved_by_pengepul_id', $userId);
        })->count();

        // === Total TBS terdistribusi (dikirim ke PKS) ===
        $tbsTerdistribusi = PenimbanganPks::whereHas('penawaran', function ($q) use ($userId) {
            $q->where('pengepul_id', $userId);
        })->sum('netto');

        // === Harga TBS terbaru ===
        $hargaTbs = HargaTbsMingguan::latest('tanggal')->first();

        // === Data grafik harga mingguan (line chart) ===
        $dataHarga = HargaTbsMingguan::orderBy('tanggal', 'asc')->take(6)->get();

        // === Grafik Bar: pembelian (baik) dan penjualan (netto) per bulan ===
        $pembelianPerBulan = PenimbanganPengepul::select(
            DB::raw('MONTH(tanggal_penimbangan) as bulan'),
            DB::raw('SUM(tbs_baik_kg) as total_baik')
        )
            ->whereHas('penawaran', fn($q) => $q->where('reserved_by_pengepul_id', $userId))
            ->groupBy('bulan')
            ->pluck('total_baik', 'bulan');

        $penjualanPerBulan = PenimbanganPks::select(
            DB::raw('MONTH(tanggal_penerimaan) as bulan'),
            DB::raw('SUM(netto) as total_netto')
        )
            ->whereHas('penawaran', fn($q) => $q->where('pengepul_id', $userId))
            ->groupBy('bulan')
            ->pluck('total_netto', 'bulan');

        // === Diagram pie: pembelian per petani (persentase) ===
        $pembelianPerPetani = PenimbanganPengepul::select(
            DB::raw('penawaran_tbs_id'),
            DB::raw('SUM(tbs_baik_kg) as total_kg')
        )
            ->whereHas('penawaran', fn($q) => $q->where('reserved_by_pengepul_id', $userId))
            ->groupBy('penawaran_tbs_id')
            ->with('penawaran.petani')
            ->get();

        $totalKg = $pembelianPerPetani->sum('total_kg');
        $dataPie = $pembelianPerPetani->map(function ($item) use ($totalKg) {
            return [
                'petani' => $item->penawaran->petani->username ?? 'Tidak diketahui',
                'persentase' => $totalKg > 0 ? round(($item->total_kg / $totalKg) * 100, 2) : 0,
            ];
        });

        // === Grafik line TBS baik vs reject ===
        $grafikTbs = PenimbanganPengepul::select(
            DB::raw('DATE(tanggal_penimbangan) as tanggal'),
            DB::raw('SUM(tbs_baik_kg) as total_baik'),
            DB::raw('SUM(tbs_reject_kg) as total_reject')
        )
            ->whereHas('penawaran', fn($q) => $q->where('reserved_by_pengepul_id', $userId))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->take(7)
            ->get();

        return view('pengepul.dashboard.index', compact(
            'laporanMasuk',
            'tbsTerdistribusi',
            'hargaTbs',
            'dataHarga',
            'pembelianPerBulan',
            'penjualanPerBulan',
            'dataPie',
            'grafikTbs'
        ));
    }
}
