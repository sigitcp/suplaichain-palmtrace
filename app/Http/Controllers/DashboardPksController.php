<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PenimbanganPengepul;
use App\Models\PenimbanganPks;
use App\Models\HargaTbsMingguan;
use App\Models\HargaCpoMingguan;

class DashboardPksController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // === Jumlah laporan masuk (penimbangan dari pengepul ke PKS) ===
        $laporanMasuk = PenimbanganPks::whereHas('penawaran', function ($q) use ($userId) {
            $q->where('pks_id', $userId);
        })->count();

        // === Total TBS dibeli (netto dari penimbangan PKS) ===
        $tbsTerdistribusi = PenimbanganPks::sum('netto');

        // === Harga TBS & CPO terbaru ===
        $hargaTbs = HargaTbsMingguan::latest('tanggal')->first();
        $hargaCpo = HargaCpoMingguan::latest('tanggal')->first();

        // === Data grafik harga mingguan (TBS & CPO) ===
        $dataHargaTbs = HargaTbsMingguan::orderBy('tanggal', 'asc')->take(8)->get();
        $dataHargaCpo = HargaCpoMingguan::orderBy('tanggal', 'asc')->take(8)->get();

        // === Grafik Bar: pembelian per bulan berdasarkan tanggal_penerimaan ===
        $pembelianPerBulan = PenimbanganPks::select(
            DB::raw('MONTH(tanggal_penerimaan) as bulan'),
            DB::raw('SUM(netto) as total_netto')
        )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total_netto', 'bulan');

        // Pastikan semua bulan 1-12 muncul (isi 0 jika tidak ada data)
        $dataBulan = collect(range(1, 12))->mapWithKeys(function ($bulan) use ($pembelianPerBulan) {
            return [$bulan => $pembelianPerBulan[$bulan] ?? 0];
        });

        // === Diagram pie: pembelian per pengepul ===
        $pembelianPerPengepul = PenimbanganPks::select(
            DB::raw('penawaran_pengepul_id'),
            DB::raw('SUM(netto) as total_kg')
        )
            ->with('penawaran.pengepul')
            ->groupBy('penawaran_pengepul_id')
            ->get();

        $totalKg = $pembelianPerPengepul->sum('total_kg');
        $dataPie = $pembelianPerPengepul->map(function ($item) use ($totalKg) {
            return [
                'pengepul' => $item->penawaran->pengepul->username ?? 'Tidak diketahui',
                'persentase' => $totalKg > 0 ? round(($item->total_kg / $totalKg) * 100, 2) : 0,
            ];
        });

        return view('pks.dashboard.index', compact(
            'laporanMasuk',
            'tbsTerdistribusi',
            'hargaTbs',
            'hargaCpo',
            'dataHargaTbs',
            'dataHargaCpo',
            'dataBulan',
            'dataPie'
        ));
    }
}
