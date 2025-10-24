<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelPetaniController extends Controller
{
    // Menampilkan daftar artikel (hanya yang published)
    public function index()
    {
        $artikels = Artikel::where('published', true)
            ->latest()
            ->paginate(6);

        return view('petani.artikel.index', compact('artikels'));
    }

    // Menampilkan detail artikel
    public function show($id)
    {
        $artikel = Artikel::where('published', true)->findOrFail($id);

        return view('petani.artikel.detail', compact('artikel'));
    }
}
