@extends('layouts.master')

@section('container')
<div class="container-fluid content-inner py-3">
    <h4 class="mb-4">Detail Pabrik Kelapa Sawit (PKS)</h4>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <strong>{{ $pks->nama_pks }}</strong>
        </div>
        <div class="card-body">
            <p><strong>Alamat:</strong> {{ $pks->alamat }}</p>
            <p><strong>Kapasitas Produksi:</strong> {{ number_format($pks->kapasitas_tbs_kg ?? 0) }} Kg/hari</p>
            <p><strong>Koordinat:</strong> {{ $pks->latitude }}, {{ $pks->longitude }}</p>
            <p><strong>Link Google Maps:</strong>
                @if ($pks->gmap_link)
                    <a href="{{ $pks->gmap_link }}" target="_blank">Lihat di Google Maps</a>
                @else
                    -
                @endif
            </p>

            @if ($pks->foto_kantor)
                <div class="my-3">
                    <img src="{{ asset('storage/' . $pks->foto_kantor) }}" alt="Foto Kantor PKS" class="img-fluid rounded">
                </div>
            @endif

            <div id="mapDetail" style="height: 400px; border-radius: 8px;"></div>
        </div>
    </div>
</div>

{{-- Map --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var lat = {{ $pks->latitude ?? 0 }};
        var lng = {{ $pks->longitude ?? 0 }};

        var map = L.map('mapDetail').setView([lat, lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        L.marker([lat, lng])
            .addTo(map)
            .bindPopup("<strong>{{ $pks->nama_pks }}</strong><br>{{ $pks->alamat }}")
            .openPopup();
    });
</script>
@endsection
