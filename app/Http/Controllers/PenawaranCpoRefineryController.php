<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PksCpoOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenawaranCpoRefineryController extends Controller
{
    public function index()
    {
        // Ambil semua penawaran PKS yang berstatus open
        $offers = PksCpoOffer::with('pks')
            ->where('status', 'open')
            ->latest()
            ->get();

        return view('refinery.penawarancpo.index', compact('offers'));
    }
}
