<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // ✅ tambahkan ini
use App\Models\PksCpoOffer;

class PksCpoOfferController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Cek apakah PKS sudah pernah membuka penawaran
        $offer = PksCpoOffer::where('pks_user_id', $userId)->latest()->first();

        return view('pks.cpo_offer.index', compact('offer'));
    }

    public function storeOrUpdate(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'kapasitas_tahunan_kg' => 'nullable|numeric',
            'palmitat' => 'nullable|numeric',
            'oleat' => 'nullable|numeric',
            'linoleat' => 'nullable|numeric',
            'stearat' => 'nullable|numeric',
            'myristat' => 'nullable|numeric',
            'trigliserida' => 'nullable|numeric',
            'ffa' => 'nullable|numeric',
            'fosfatida' => 'nullable|numeric',
            'karoten' => 'nullable|numeric',
            'dokumen_lab' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Upload dokumen jika ada
        if ($request->hasFile('dokumen_lab')) {
            $oldOffer = PksCpoOffer::where('pks_user_id', $userId)->first();

            // Hapus file lama dari storage jika ada
            if ($oldOffer && $oldOffer->dokumen_lab && Storage::disk('public')->exists($oldOffer->dokumen_lab)) {
                Storage::disk('public')->delete($oldOffer->dokumen_lab);
            }

            // Simpan file baru ke folder dokumenlabcpo
            $validated['dokumen_lab'] = $request->file('dokumen_lab')->store('dokumenlabcpo', 'public');
        }

        // Simpan atau update penawaran
        PksCpoOffer::updateOrCreate(
            ['pks_user_id' => $userId],
            array_merge($validated, ['status' => 'open'])
        );

        return redirect()->route('pks.cpooffer.index')->with('success', 'Penawaran CPO berhasil dibuka atau diperbarui.');
    }

    public function toggleStatus()
    {
        $userId = Auth::id();
        $offer = PksCpoOffer::where('pks_user_id', $userId)->first();

        if ($offer) {
            $offer->status = $offer->status === 'open' ? 'closed' : 'open';
            $offer->save();

            return redirect()->back()->with('success', 'Status penawaran berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Data penawaran tidak ditemukan.');
    }
}
