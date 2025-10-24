<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilPetani;

class DetailProfilPetaniController extends Controller
{
    /**
     * Tampilkan detail profil petani
     */
    public function index()
    {
        $profil = ProfilPetani::where('user_id', Auth::id())->first();

        return view('petani.profil.index', compact('profil'));
    }
}
