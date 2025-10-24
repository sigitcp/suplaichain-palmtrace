@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4>Detail Profil Refinery</h4>
                        </div>
                        <div>
                            {{-- Notifikasi --}}
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-warning">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <button class="btn btn-sm btn-info d-flex align-items-center"
                            title="Tambah / Edit Detail"
                            data-bs-toggle="modal"
                            data-bs-target="#profilRefineryAddModal">
                            <span class="btn-inner d-flex align-items-center">
                                Kelola Profil
                            </span>
                        </button>
                    </div>
                </div>

                <div class="row">
                    {{-- Informasi Refinery --}}
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <div class="header-title">
                                    <h4 class="card-title">Informasi Refinery</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(!empty($profil))
                                <ul class="list-inline m-0 p-0">
                                    <div class="pb-2">
                                        <h6>Nama Refinery:
                                            <strong class="ms-1">{{ $profil->nama_refinery ?? '-' }}</strong>
                                        </h6>
                                    </div>
                                    <div class="pb-2">
                                        <h6>Kapasitas TBS (Kg):
                                            <strong class="ms-1">{{ $profil->kapasitas_tbs_kg ?? '-' }}</strong>
                                        </h6>
                                    </div>
                                    <div class="pb-2">
                                        <h6>Alamat:
                                            @if($profil->gmap_link)
                                                <a href="{{ $profil->gmap_link }}" target="_blank">
                                                    <strong class="ms-1">{{ $profil->alamat ?? '-' }}</strong>
                                                </a>
                                            @else
                                                <strong class="ms-1">{{ $profil->alamat ?? '-' }}</strong>
                                            @endif
                                        </h6>
                                    </div>
                                    <div class="pb-2">
                                        <h6>Koordinat:
                                            <strong class="ms-1">{{ $profil->latitude ?? '-' }}, {{ $profil->longitude ?? '-' }}</strong>
                                        </h6>
                                    </div>
                                </ul>
                                @if($profil->foto_kantor)
                                    <div class="mt-3 text-center">
                                        <img src="{{ asset('storage/' . $profil->foto_kantor) }}" 
                                             alt="Foto Kantor" 
                                             class="img-fluid rounded shadow">
                                    </div>
                                @endif
                                @else
                                <div class="alert alert-warning text-center mb-0">
                                    Belum ada data profil Refinery.
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Peta --}}
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-header">
                                <div class="header-title">
                                    <h4 class="card-title">Titik Koordinat Refinery</h4>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div id="map" style="width: 100%; height:400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Leaflet --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var map = L.map('map').setView([0.0645, 109.4050], 7);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    @if(!empty($profil) && $profil->latitude && $profil->longitude)
        var lat = {{ $profil->latitude }};
        var lng = {{ $profil->longitude }};
        var marker = L.marker([lat, lng]).addTo(map)
            .bindPopup("Lokasi Refinery: {{ $profil->nama_refinery ?? 'Tidak diketahui' }}")
            .openPopup();
        map.setView([lat, lng], 13);
    @endif
});
</script>

@include('admin.refinery.profil.modal.create')
@endsection
