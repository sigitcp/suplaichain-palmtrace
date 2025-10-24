<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PenimbanganPengepul;
use App\Models\PenimbanganPks;

class RiwayatTransaksiPengepulController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Riwayat pembelian dari petani (detail)
        $riwayatPetani = PenimbanganPengepul::whereHas('penawaran', function ($q) use ($userId) {
                $q->where('reserved_by_pengepul_id', $userId);
            })
            ->with(['penawaran.petani'])
            ->orderBy('tanggal_penimbangan', 'desc')
            ->get();

        // Riwayat penjualan ke PKS (detail)
        $riwayatPks = PenimbanganPks::whereHas('penawaran', function ($q) use ($userId) {
                $q->where('pengepul_id', $userId);
            })
            ->with(['penawaran.pks'])
            ->orderBy('tanggal_penerimaan', 'desc')
            ->get();

        // Pembelian per bulan (menghitung nilai uang: total_baik + total_reject)
        $pembelianPerBulan = PenimbanganPengepul::select(
                DB::raw('MONTH(tanggal_penimbangan) as bulan'),
                DB::raw('SUM(COALESCE(total_baik,0) + COALESCE(total_reject,0)) as total')
            )
            ->whereHas('penawaran', fn($q) => $q->where('reserved_by_pengepul_id', $userId))
            ->groupBy('bulan')
            ->pluck('total', 'bulan'); // hasil: ['10' => 4200000, ...]

        // Penjualan per bulan (nilai dari penimbangan_pks: total_transaksi)
        $penjualanPerBulan = PenimbanganPks::select(
                DB::raw('MONTH(tanggal_penerimaan) as bulan'),
                DB::raw('SUM(COALESCE(total_transaksi,0)) as total')
            )
            ->whereHas('penawaran', fn($q) => $q->where('pengepul_id', $userId))
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // Jika ingin memastikan array berisi 12 bulan (Jan..Des) dengan 0 default:
        $months = range(1, 12);
        $pembelianValues = [];
        $penjualanValues = [];
        foreach ($months as $m) {
            $pembelianValues[] = isset($pembelianPerBulan[$m]) ? (float) $pembelianPerBulan[$m] : 0;
            $penjualanValues[] = isset($penjualanPerBulan[$m]) ? (float) $penjualanPerBulan[$m] : 0;
        }

        // Kembalikan view (sesuaikan path view-mu)
        return view('pengepul.riwayattransaksi.index', compact(
            'riwayatPetani',
            'riwayatPks',
            'pembelianPerBulan',
            'penjualanPerBulan',
            'pembelianValues',
            'penjualanValues'
        ));
    }
}
