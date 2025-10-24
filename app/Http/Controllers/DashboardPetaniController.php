<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenimbanganPengepul;
use App\Models\HargaTbsMingguan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardPetaniController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua data penimbangan milik petani login
        $penimbangan = PenimbanganPengepul::whereHas('penawaran', function ($q) use ($user) {
            $q->where('petani_user_id', $user->id);
        })
        ->orderBy('tanggal_penimbangan', 'asc')
        ->get();

        // Total panen baik & reject
        $totalBaik = $penimbangan->sum('tbs_baik_kg');
        $totalReject = $penimbangan->sum('tbs_reject_kg');

        // Panen terakhir
        $panenTerakhir = $penimbangan->sortByDesc('tanggal_penimbangan')->first();
        $totalPanenTerakhir = $panenTerakhir
            ? $panenTerakhir->tbs_baik_kg + $panenTerakhir->tbs_reject_kg
            : 0;

        $tanggalPanenTerakhir = $panenTerakhir
            ? Carbon::parse($panenTerakhir->tanggal_penimbangan)->translatedFormat('d F Y')
            : '-';

        // ==============================
        // 📊 Data untuk line chart
        // ==============================
        $labels = $penimbangan->map(function ($item) {
            return Carbon::parse($item->tanggal_penimbangan)->translatedFormat('d M Y');
        });

        $dataBaik = $penimbangan->pluck('tbs_baik_kg');
        $dataReject = $penimbangan->pluck('tbs_reject_kg');

        // Jika belum ada data, isi default agar tidak error
        if ($labels->isEmpty()) {
            $labels = collect([Carbon::now()->translatedFormat('d M Y')]);
            $dataBaik = collect([0]);
            $dataReject = collect([0]);
        }

        // ==============================
        // 💰 Harga Pasar
        // ==============================
        $hargaTbs = HargaTbsMingguan::orderByDesc('tanggal')->take(2)->get();

        $hargaSekarang = $hargaTbs->first()->harga_per_kg ?? 0;
        $hargaSebelumnya = $hargaTbs->count() > 1
            ? $hargaTbs[1]->harga_per_kg
            : $hargaSekarang;

        $perubahanPersen = 0;
        if ($hargaSebelumnya > 0) {
            $perubahanPersen = (($hargaSekarang - $hargaSebelumnya) / $hargaSebelumnya) * 100;
        }

        return view('petani.dashboard.index', compact(
            'totalBaik',
            'totalReject',
            'totalPanenTerakhir',
            'tanggalPanenTerakhir',
            'labels',
            'dataBaik',
            'dataReject',
            'hargaSekarang',
            'perubahanPersen'
        ));
    }
}
