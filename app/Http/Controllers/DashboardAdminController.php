<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfilPetani;
use App\Models\ProfilPengepul;
use App\Models\ProfilPks;
use App\Models\ProfilRefinery;
use App\Models\HargaTbsMingguan;
use App\Models\HargaCpoMingguan;
use App\Models\DetailLahan;
use Carbon\Carbon;


class DashboardAdminController extends Controller
{
    public function index()
    {
        // === Statistik Pengguna ===
        $jumlahPetani   = User::where('role_id', 2)->count();
        $jumlahPengepul = User::where('role_id', 3)->count();
        $jumlahPks      = User::where('role_id', 4)->count();
        $jumlahRefinery = User::where('role_id', 5)->count();

        // === Statistik Lahan ===
        $jumlahPoligon = DetailLahan::whereNotNull('file_geojson')->count();
        $totalLuasLahan = ProfilPetani::sum('luasan_lahan_total');

        // === Data Grafik Harga TBS ===
        $tbsData = HargaTbsMingguan::orderBy('tanggal')->get();
        $tbsTanggal = $tbsData->pluck('tanggal')->map(fn($d) => Carbon::parse($d)->format('d M'));
        $tbsHarga   = $tbsData->pluck('harga_per_kg');

        // === Data Grafik Harga CPO ===
        $cpoData = HargaCpoMingguan::orderBy('tanggal')->get();
        $cpoTanggal = $cpoData->pluck('tanggal')->map(fn($d) => Carbon::parse($d)->format('d M'));
        $cpoHarga   = $cpoData->pluck('harga_per_kg');

        // === Data untuk Peta ===
        $petani     = ProfilPetani::select('nama_petani as nama', 'latitude', 'longitude')->get();
        $pengepul   = ProfilPengepul::select('nama_koperasi as nama', 'latitude', 'longitude')->get();
        $pks        = ProfilPks::select('nama_pks as nama', 'latitude', 'longitude')->get();
        $refinery   = ProfilRefinery::select('nama_refinery as nama', 'latitude', 'longitude')->get();
        $lahan      = DetailLahan::with('lahan')->get();

        return view('admin.dashboard.index', compact(
            'jumlahPetani',
            'jumlahPengepul',
            'jumlahPks',
            'jumlahRefinery',
            'jumlahPoligon',
            'totalLuasLahan',
            'tbsTanggal',
            'tbsHarga',
            'cpoTanggal',
            'cpoHarga',
            'petani',
            'pengepul',
            'pks',
            'refinery',
            'lahan'
        ));
    }
}
