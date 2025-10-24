<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenawaranTbs;
use Illuminate\Support\Facades\Auth;

class PengepulPenawaranTbsController extends Controller
{
    public function index()
    {
        $penawarans = PenawaranTbs::where('status', 'open')->with('petani')->get();
        return view('pengepul.penawarantbs.index', compact('penawarans'));
    }

    public function reserve(Request $request, $id)
    {
        $penawaran = PenawaranTbs::findOrFail($id);

        // Pastikan masih open
        if ($penawaran->status !== 'open') {
            return redirect()->back()->with('error', 'Penawaran sudah tidak tersedia.');
        }

        // Jika dijemput, wajib isi tanggal & nomor armada
        if ($penawaran->is_pickup) {
            $request->validate([
                'tanggal_penjemputan' => 'required|date',
                'nomor_armada_penjemputan' => 'required|string|max:50',
            ]);

            $penawaran->update([
                'status' => 'reserved',
                'reserved_by_pengepul_id' => Auth::id(),
                'tanggal_penjemputan' => $request->tanggal_penjemputan,
                'nomor_armada_penjemputan' => $request->nomor_armada_penjemputan,
            ]);
        } else {
            // Jika diantar petani, cukup ubah status dan reserved_by
            $penawaran->update([
                'status' => 'reserved',
                'reserved_by_pengepul_id' => Auth::id(),
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil membeli penawaran TBS dari petani!');
    }

    public function cancel($id)
    {
        $penawaran = PenawaranTbs::findOrFail($id);

        if ($penawaran->reserved_by_pengepul_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak membatalkan penawaran ini.');
        }

        $penawaran->update([
            'status' => 'open',
            'reserved_by_pengepul_id' => null,
            'tanggal_penjemputan' => null,
            'nomor_armada_penjemputan' => null,
        ]);

        return redirect()->back()->with('success', 'Penawaran berhasil dibatalkan.');
    }
}
