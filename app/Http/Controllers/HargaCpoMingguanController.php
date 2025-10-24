<?php

namespace App\Http\Controllers;

use App\Models\HargaCpoMingguan;
use Illuminate\Http\Request;

class HargaCpoMingguanController extends Controller
{
    /**
     * Tampilkan daftar harga CPO mingguan dan grafiknya.
     */
    public function index()
    {
        // ambil data terurut berdasarkan tanggal (naik)
        $data = HargaCpoMingguan::orderBy('tanggal', 'asc')->get();

        // kirim ke view sebagai $data (sesuai view kamu)
        return view('admin.hargacpo.index', compact('data'));
    }

    /**
     * Simpan data harga baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:harga_cpo_mingguans,tanggal',
            'harga_per_kg' => 'required|numeric|min:0',
        ]);

        HargaCpoMingguan::create([
            'tanggal' => $request->input('tanggal'),
            'harga_per_kg' => $request->input('harga_per_kg'),
        ]);

        return redirect()->back()->with('success', 'Data harga CPO berhasil ditambahkan.');
    }

    /**
     * Update data harga.
     */
    public function update(Request $request, $id)
    {
        $record = HargaCpoMingguan::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date|unique:harga_cpo_mingguans,tanggal,' . $id,
            'harga_per_kg' => 'required|numeric|min:0',
        ]);

        $record->update([
            'tanggal' => $request->input('tanggal'),
            'harga_per_kg' => $request->input('harga_per_kg'),
        ]);

        return redirect()->back()->with('success', 'Data harga CPO berhasil diperbarui.');
    }

    /**
     * Hapus data harga.
     */
    public function destroy($id)
    {
        $record = HargaCpoMingguan::findOrFail($id);
        $record->delete();

        return redirect()->back()->with('success', 'Data harga CPO berhasil dihapus.');
    }
}
