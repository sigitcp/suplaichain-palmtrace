<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PenimbanganPengepul;
use Carbon\Carbon;

class RiwayatTransaksiPetaniController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Ambil semua penimbangan yang terkait dengan petani login
        $riwayat = PenimbanganPengepul::with(['penawaran', 'penjualan'])
            ->whereHas('penawaran', function ($q) use ($userId) {
                $q->where('petani_user_id', $userId);
            })
            ->orWhereHas('penjualan', function ($q) use ($userId) {
                $q->where('petani_id', $userId);
            })
            ->orderBy('tanggal_penimbangan', 'asc')
            ->get();

        // Group berdasarkan tanggal (YYYY-MM-DD)
        $chartData = $riwayat->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_penimbangan)->format('Y-m-d');
        })->map(function ($group) {
            return [
                'baik' => $group->sum('total_baik'),
                'reject' => $group->sum('total_reject')
            ];
        });

        // Ambil label (tanggal) dan nilai untuk Chart.js
        $labels = $chartData->keys()->toArray();
        $dataBaik = $chartData->pluck('baik')->values()->toArray();
        $dataReject = $chartData->pluck('reject')->values()->toArray();
        

        return view('petani.riwayattransaksi.index', compact('riwayat', 'labels', 'dataBaik', 'dataReject'));
    }
}
