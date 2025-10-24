<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilPks;
use App\Models\ProfilPengepul;

class PetaPksPengepulController extends Controller
{
    public function index()
    {
        $pks = ProfilPks::select('id', 'nama_pks as nama', 'alamat', 'latitude', 'longitude')->get();
        $pengepul = ProfilPengepul::select('id', 'nama_koperasi as nama', 'alamat', 'latitude', 'longitude')->get();

        return view('petani.pksdanpengepul.index', compact('pks', 'pengepul'));
    }

    public function show($type, $id)
    {
        if ($type === 'pks') {
            $profil = ProfilPks::findOrFail($id);
        } elseif ($type === 'pengepul') {
            $profil = ProfilPengepul::findOrFail($id);
        } else {
            abort(404);
        }

        return view('petani.pksdanpengepul.detail', compact('profil', 'type'));
    }
}
