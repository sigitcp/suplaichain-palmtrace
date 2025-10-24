<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PembukaanPenerimaanPks;
use App\Models\PenawaranPengepulKePks;
use Illuminate\Support\Facades\Storage;

class PengepulPenawaranPksController extends Controller
{
    // Halaman daftar penerimaan PKS untuk ditawar
    public function index()
    {
        $pengepulId = Auth::id();
    
        // Ambil semua ID PKS yang sudah pernah ditawar oleh pengepul ini
        $penawaranSayaIds = PenawaranPengepulKePks::where('pengepul_id', $pengepulId)
            ->pluck('pks_id')->toArray();
    
        // Ambil semua penerimaan PKS yang masih open dan belum pernah ditawar pengepul ini
        $penerimaanPks = PembukaanPenerimaanPks::where('status', 'open')
            ->whereNotIn('pks_user_id', $penawaranSayaIds)
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Ambil semua penawaran pengepul yang sudah dibuat
        $penawaranSaya = PenawaranPengepulKePks::where('pengepul_id', $pengepulId)
            ->with('pks')
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('pengepul.permintaanpks.index', compact('penerimaanPks', 'penawaranSaya'));
    }
    

    // Simpan penawaran baru
    public function store(Request $request)
    {
        $request->validate([
            'pks_id' => 'required|exists:users,id',
            'estimasi_tbs_kg' => 'required|numeric|min:1',
            'nomor_armada' => 'nullable|string|max:50',
            'nama_supir' => 'nullable|string|max:50',
            'varietas' => 'nullable|string|max:50',
            'foto_tbs.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_pengantaran' => 'required|date',
        ]);

        $pengepulId = Auth::id();
        $fotoPaths = [];

        if($request->hasFile('foto_tbs')){
            foreach($request->file('foto_tbs') as $foto){
                $path = $foto->store('fototbspengepul', 'public');
                $fotoPaths[] = $path;
            }
        }

        PenawaranPengepulKePks::create([
            'pengepul_id' => $pengepulId,
            'pks_id' => $request->pks_id,
            'estimasi_tbs_kg' => $request->estimasi_tbs_kg,
            'nomor_armada' => $request->nomor_armada,
            'nama_supir' => $request->nama_supir,
            'varietas' => $request->varietas,
            'foto_tbs' => json_encode($fotoPaths),
            'tanggal_pengantaran' => $request->tanggal_pengantaran,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Penawaran berhasil dikirim ke PKS!');
    }

    public function destroy($id)
    {
        $penawaran = PenawaranPengepulKePks::findOrFail($id);

        if($penawaran->pengepul_id != Auth::id()){
            return redirect()->back()->with('error', 'Tidak memiliki izin untuk menghapus penawaran ini.');
        }

        if($penawaran->foto_tbs){
            foreach(json_decode($penawaran->foto_tbs, true) as $foto){
                if(Storage::disk('public')->exists($foto)){
                    Storage::disk('public')->delete($foto);
                }
            }
        }

        $penawaran->delete();
        return redirect()->back()->with('success', 'Penawaran berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected,completed',
        ]);

        $penawaran = PenawaranPengepulKePks::findOrFail($id);
        $penawaran->status = $request->status;
        $penawaran->save();

        return redirect()->back()->with('success', 'Status penawaran berhasil diperbarui.');
    }
}
