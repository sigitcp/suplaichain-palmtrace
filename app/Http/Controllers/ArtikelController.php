<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
{
    /**
     * Tampilkan daftar artikel.
     */
    public function index()
    {
        $data = Artikel::with('author')->latest()->get();
        return view('admin.artikel.index', compact('data'));
    }

    /**
     * Simpan artikel baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Artikel::create([
            'author_id' => Auth::id(),
            'judul' => $request->judul,
            'isi' => $request->isi,
            'thumbnail' => $path,
            'published' => $request->has('published'),
        ]);

        return redirect()->back()->with('success', 'Artikel berhasil ditambahkan.');
    }

    /**
     * Update artikel.
     */
    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'published' => $request->has('published'),
        ];

        if ($request->hasFile('thumbnail')) {
            if ($artikel->thumbnail && Storage::disk('public')->exists($artikel->thumbnail)) {
                Storage::disk('public')->delete($artikel->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $artikel->update($data);

        return redirect()->back()->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Hapus artikel.
     */
    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        if ($artikel->thumbnail && Storage::disk('public')->exists($artikel->thumbnail)) {
            Storage::disk('public')->delete($artikel->thumbnail);
        }
        $artikel->delete();

        return redirect()->back()->with('success', 'Artikel berhasil dihapus.');
    }

    /**
     * Tampilkan detail artikel.
     */
    public function show($id)
    {
        $artikel = Artikel::with('author')->findOrFail($id);
        return view('admin.artikel.show', compact('artikel'));
    }
}
