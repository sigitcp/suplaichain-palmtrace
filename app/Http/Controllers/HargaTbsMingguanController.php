<?php

namespace App\Http\Controllers;

use App\Models\HargaTbsMingguan;
use Illuminate\Http\Request;

class HargaTbsMingguanController extends Controller
{
    /**
     * Tampilkan daftar harga TBS mingguan + grafik.
     */
    public function index()
    {
        $data = HargaTbsMingguan::orderBy('tanggal', 'asc')->get();

        return view('admin.hargatbs.index', compact('data'));
    }

    /**
     * Simpan harga baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:harga_tbs_mingguans,tanggal',
            'harga_per_kg' => 'required|numeric|min:0',
        ]);

        HargaTbsMingguan::create($request->only(['tanggal', 'harga_per_kg']));

        return redirect()->back()->with('success', 'Harga TBS berhasil ditambahkan.');
    }

    /**
     * Update data harga.
     */
    public function update(Request $request, $id)
    {
        $harga = HargaTbsMingguan::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date|unique:harga_tbs_mingguans,tanggal,' . $harga->id,
            'harga_per_kg' => 'required|numeric|min:0',
        ]);

        $harga->update($request->only(['tanggal', 'harga_per_kg']));

        return redirect()->back()->with('success', 'Harga TBS berhasil diperbarui.');
    }

    /**
     * Hapus harga.
     */
    public function destroy($id)
    {
        HargaTbsMingguan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
