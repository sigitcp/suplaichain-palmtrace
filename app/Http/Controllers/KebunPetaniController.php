<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lahan;
use App\Models\DetailLahan;
use App\Models\Panen;

class KebunPetaniController extends Controller
{
    public function index($id)
    {
        // Pastikan petani hanya bisa melihat lahannya sendiri
        $lahan = Lahan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    
        // Ambil detail lahan jika ada
        $detail = DetailLahan::where('lahan_id', $lahan->id)->first();

    
        return view('petani.monitoring.index', compact(
            'lahan',
            'detail',
        ));
    } 


}
