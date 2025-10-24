@extends('layouts.master')

@section('container')
<div class="container-fluid content-inner py-3">
    <h4 class="mb-4">Penawaran CPO dari PKS</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        @forelse ($offers as $offer)
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title text-success">{{ $offer->pks->name ?? 'Nama PKS Tidak Diketahui' }}</h5>
                        <p class="mb-1"><strong>Kapasitas Tahunan:</strong> {{ number_format($offer->kapasitas_tahunan_kg) }} Kg</p>
                        <p class="mb-1"><strong>Alamat PKS:</strong> {{ $offer->pks->alamat?? '-' }}</p>
                        <span class="badge {{ $offer->status == 'open' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($offer->status) }}
                        </span>
                    </div>
                    <div class="card-footer bg-light">
                        <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#detailModal{{ $offer->id }}">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Detail -->
            <div class="modal fade" id="detailModal{{ $offer->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $offer->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalLabel{{ $offer->id }}">Detail Penawaran CPO - {{ $offer->pks->name ?? 'PKS' }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Palmitat:</strong> {{ $offer->palmitat }}%</p>
                                    <p><strong>Oleat:</strong> {{ $offer->oleat }}%</p>
                                    <p><strong>Linoleat:</strong> {{ $offer->linoleat }}%</p>
                                    <p><strong>Stearat:</strong> {{ $offer->stearat }}%</p>
                                    <p><strong>Myristat:</strong> {{ $offer->myristat }}%</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Trigliserida:</strong> {{ $offer->trigliserida }}%</p>
                                    <p><strong>FFA (Asam Lemak Bebas):</strong> {{ $offer->ffa }}%</p>
                                    <p><strong>Fosfatida:</strong> {{ $offer->fosfatida }}%</p>
                                    <p><strong>Karoten:</strong> {{ $offer->karoten }} ppm</p>
                                    <p><strong>Dokumen Lab:</strong>
                                        @if ($offer->dokumen_lab)
                                            <a href="{{ Storage::url($offer->dokumen_lab) }}" target="_blank">{{ basename($offer->dokumen_lab) }}</a>
                                        @else
                                            <span class="text-muted">Tidak ada dokumen</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-success">Ajukan Kerjasama</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada penawaran CPO yang berstatus <strong>open</strong>.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
