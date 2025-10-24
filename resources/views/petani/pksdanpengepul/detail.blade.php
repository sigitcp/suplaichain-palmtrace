@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
    <div class="row">
        <div class="col-sm-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        Detail {{ $type === 'pks' ? 'Pabrik Kelapa Sawit (PKS)' : 'Pengepul' }}
                    </h4>
                    <a href="{{ route('petani.peta.index') }}" class="btn btn-secondary btn-sm">← Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Foto --}}
                        <div class="col-md-4">
                            <img src="{{ $profil->foto_kantor ? asset('storage/'.$profil->foto_kantor) : asset('images/no-image.jpg') }}" 
                                 class="img-fluid rounded mb-3" alt="Foto">
                        </div>

                        {{-- Detail --}}
                        <div class="col-md-8">
                            @if($type === 'pks')
                                <h5>{{ $profil->nama_pks }}</h5>
                                <p><strong>Kapasitas:</strong> {{ $profil->kapasitas_tbs_kg ?? '-' }} kg</p>
                                <p><strong>Alamat:</strong> {{ $profil->alamat }}</p>
                                <p><strong>Koordinat:</strong> {{ $profil->latitude }}, {{ $profil->longitude }}</p>
                            @else
                                <h5>{{ $profil->nama_koperasi }}</h5>
                                <p><strong>Kapasitas:</strong> {{ $profil->kapasitas_tbs ?? '-' }} ton</p>
                                <p><strong>Alamat:</strong> {{ $profil->alamat }}</p>
                                <p><strong>Koordinat:</strong> {{ $profil->latitude }}, {{ $profil->longitude }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Peta --}}
                    <div id="map" style="height: 400px;" class="mt-4 rounded"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Leaflet --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var lat = {{ $profil->latitude ?? 0 }};
    var lng = {{ $profil->longitude ?? 0 }};
    var map = L.map('map').setView([lat, lng], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup("{{ $type === 'pks' ? $profil->nama_pks : $profil->nama_koperasi }}")
        .openPopup();
});
</script>
@endsection
