@extends('layouts.master')

@section('container')
<div class="container-fluid content-inner py-3">
    <h4 class="mb-4">Penawaran CPO oleh PKS</h4>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <strong>Form / Detail Penawaran CPO</strong>
        </div>
        <div class="card-body">
            @if(!$offer || $offer->status == 'closed')
                {{-- Form membuka penawaran --}}
                <form action="{{ route('pks.cpooffer.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kapasitas Tahunan (Kg)</label>
                            <input type="number" name="kapasitas_tahunan_kg" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Dokumen Lab (PDF / JPG / PNG)</label>
                            <input type="file" name="dokumen_lab" class="form-control">
                        </div>

                        <div class="col-md-2"><label>Palmitat</label><input name="palmitat" type="number" step="0.001" class="form-control"></div>
                        <div class="col-md-2"><label>Oleat</label><input name="oleat" type="number" step="0.001" class="form-control"></div>
                        <div class="col-md-2"><label>Linoleat</label><input name="linoleat" type="number" step="0.001" class="form-control"></div>
                        <div class="col-md-2"><label>Stearat</label><input name="stearat" type="number" step="0.001" class="form-control"></div>
                        <div class="col-md-2"><label>Myristat</label><input name="myristat" type="number" step="0.001" class="form-control"></div>
                        <div class="col-md-2"><label>Trigliserida</label><input name="trigliserida" type="number" step="0.001" class="form-control"></div>
                        <div class="col-md-2"><label>FFA</label><input name="ffa" type="number" step="0.001" class="form-control"></div>
                        <div class="col-md-2"><label>Fosfatida</label><input name="fosfatida" type="number" step="0.001" class="form-control"></div>
                        <div class="col-md-2"><label>Karoten</label><input name="karoten" type="number" step="0.001" class="form-control"></div>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Buka Penawaran</button>
                </form>
            @else
                {{-- Detail penawaran --}}
                <p><strong>Status:</strong>
                    <span class="badge {{ $offer->status == 'open' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst($offer->status) }}
                    </span>
                </p>

                <p><strong>Kapasitas Tahunan:</strong> {{ number_format($offer->kapasitas_tahunan_kg ?? 0) }} Kg</p>
                <p><strong>Komposisi:</strong></p>
                <ul>
                    <li>Palmitat: {{ $offer->palmitat ?? '-' }}</li>
                    <li>Oleat: {{ $offer->oleat ?? '-' }}</li>
                    <li>Linoleat: {{ $offer->linoleat ?? '-' }}</li>
                    <li>Stearat: {{ $offer->stearat ?? '-' }}</li>
                    <li>Myristat: {{ $offer->myristat ?? '-' }}</li>
                    <li>Trigliserida: {{ $offer->trigliserida ?? '-' }}</li>
                    <li>FFA: {{ $offer->ffa ?? '-' }}</li>
                    <li>Fosfatida: {{ $offer->fosfatida ?? '-' }}</li>
                    <li>Karoten: {{ $offer->karoten ?? '-' }}</li>
                </ul>

                @if($offer->dokumen_lab)
                    <p><strong>Dokumen Lab:</strong> 
                        <a href="{{ asset('storage/' . $offer->dokumen_lab) }}" target="_blank" class="btn btn-sm btn-primary">
                            Lihat Dokumen
                        </a>
                    </p>
                @endif

                <p><strong>Tanggal Dibuka:</strong> {{ $offer->created_at->format('d M Y H:i') }}</p>

                {{-- Tombol Tutup Penawaran --}}
                <form action="{{ route('pks.cpooffer.toggle') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Tutup Penawaran
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
