<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilPks;

class PetaPksController extends Controller
{
    public function index()
    {
        // Ambil semua data PKS dari tabel profil_pks
        $pksList = ProfilPks::with('user')->get();

        return view('refinery.peta_pks', compact('pksList'));
    }

    public function show($id)
    {
        // Ambil data PKS berdasarkan ID
        $pks = ProfilPks::with('user')->findOrFail($id);

        return view('refinery.detail_pks', compact('pks'));
    }
}
