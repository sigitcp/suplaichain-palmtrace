@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4>Detail Profil Pengepul</h4>
                        </div>
                        <div>
                            {{-- Alert Notifikasi --}}
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
                        <button class="btn btn-sm btn-success d-flex align-items-center"
                            title="Tambah / Edit Detail"
                            data-bs-toggle="modal"
                            data-bs-target="#profilPengepulAddModal">
                            <span class="btn-inner d-flex align-items-center">
                                Kelola Profil
                            </span>
                        </button>
                    </div>
                </div>

                <div class="row">
                    {{-- Informasi Pengepul --}}
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <div class="header-title">
                                    <h4 class="card-title">Informasi Pengepul</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(!empty($profil))
                                <ul class="list-inline m-0 p-0">
                                    <div class="pb-2">
                                        <h6>Nama Pengepul/Koperasi:
                                            <strong class="ms-1">{{ $profil->nama_koperasi ?? '-' }}</strong>
                                        </h6>
                                    </div>
                                    <div class="pb-2">
                                        <h6>Kapasitas Menampung TBS:
                                            <strong class="ms-1">{{ $profil->kapasitas_tbs ?? '-' }} ton</strong>
                                        </h6>
                                    </div>
                                    <div class="pb-2">
                                        <h6>Alamat:
                                            @if($profil->gmap_link)
                                            <a href="{{ $profil->gmaps_link }}" target="_blank">
                                                <strong class="ms-1">{{ $profil->alamat ?? '-' }}</strong>
                                            </a>
                                            @else
                                            <strong class="ms-1">{{ $profil->alamat ?? '-' }}</strong>
                                            @endif
                                        </h6>
                                    </div>
                                </ul>
                                @else
                                <div class="alert alert-warning text-center mb-0">
                                    Belum ada data profil pengepul.
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Sertifikat --}}
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="header-title">
                                    <h4 class="card-title">Sertifikat Koperasi</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(!empty($profil) && $profil->sertifikat_koperasi)
                                <iframe src="{{ asset('storage/' . $profil->sertifikat_koperasi) }}"
                                    height="400px" width="100%">
                                </iframe>
                                @else
                                <div class="alert alert-warning text-center">
                                    Sertifikat belum diunggah.
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Peta & Foto --}}
                    <div class="col-lg-7">
                        {{-- Peta --}}
                        <div class="card">
                            <div class="card-header">
                                <div class="header-title">
                                    <h4 class="card-title">Titik Koordinat Pengepul</h4>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div id="map" style="width: 100%; height:400px;"></div>
                            </div>
                        </div>

                        {{-- Foto --}}
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="header-title">
                                    <h4 class="card-title">Foto Kantor Pengepul</h4>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if(!empty($profil) && $profil->foto_kantor)
                                <img src="{{ asset('storage/' . $profil->foto_kantor) }}" class="img-fluid rounded" alt="Foto Kantor">
                                @else
                                <svg class="bd-placeholder-img card-img-top" width="100%" height="180"
                                    xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice">
                                    <title>Placeholder</title>
                                    <rect width="100%" height="100%" fill="#868e96"></rect>
                                    <text x="25%" y="50%" fill="#dee2e6" dy=".3em">Belum Ada Foto Kantor</text>
                                </svg>
                                @endif
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
        // Default Kalimantan Barat
        var map = L.map('map').setView([0.0645, 109.4050], 7);
        var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        @if(!empty($profil) && $profil->latitude && $profil->longitude)
            // Jika ada koordinat, tampilkan marker dan zoom
            var lat = {{ $profil->latitude }};
            var lng = {{ $profil->longitude }};
            var marker = L.marker([lat, lng]).addTo(map)
                .bindPopup("Lokasi Kantor Pengepul: {{ $profil->nama_koperasi ?? 'Tidak diketahui' }}")
                .openPopup();
            map.setView([lat, lng], 13);
        @endif
    });
</script>

@include('admin.pengepul.profil.modal.create')
@endsection
