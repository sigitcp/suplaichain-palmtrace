<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PenawaranTbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetaniPenawaranTbsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek apakah masih ada penawaran open atau reserved
        $aktif = PenawaranTbs::where('petani_user_id', $user->id)
            ->whereIn('status', ['open', 'reserved'])
            ->exists();

        $penawarans = PenawaranTbs::where('petani_user_id', $user->id)->latest()->get();

        return view('petani.penawarantbs.index', compact('penawarans', 'aktif'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Cegah buka penawaran baru kalau masih ada yang open atau reserved
        $adaAktif = PenawaranTbs::where('petani_user_id', $user->id)
            ->whereIn('status', ['open', 'reserved'])
            ->exists();

        if ($adaAktif) {
            return back()->with('error', 'Anda masih memiliki penawaran aktif.');
        }

        $validated = $request->validate([
            'estimasi_tbs_kg' => 'required|numeric|min:1',
            'is_pickup' => 'required|boolean',
            'tanggal_pengantaran' => 'nullable|date',
            'nomor_armada_pengantaran' => 'nullable|string',
        ]);

        $data = [
            'petani_user_id' => $user->id,
            'estimasi_tbs_kg' => $validated['estimasi_tbs_kg'],
            'is_pickup' => $validated['is_pickup'],
            'status' => 'open',
        ];

        if ($validated['is_pickup'] == false) {
            $data['tanggal_pengantaran'] = $request->tanggal_pengantaran;
            $data['nomor_armada_pengantaran'] = $request->nomor_armada_pengantaran;
        }

        PenawaranTbs::create($data);

        return redirect()->back()->with('success', 'Penawaran berhasil dibuka.');
    }

    public function destroy($id)
    {
        $penawaran = PenawaranTbs::findOrFail($id);
        if ($penawaran->status == 'open') {
            $penawaran->delete();
            return back()->with('success', 'Penawaran berhasil dihapus.');
        }

        return back()->with('error', 'Penawaran tidak dapat dihapus.');
    }
}
