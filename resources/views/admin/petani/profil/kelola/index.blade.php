@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4>Detail Profil Petani</h4>
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
                        <button class="btn btn-sm btn-success d-flex align-items-center"
                            title="Tambah / Edit Detail"
                            data-bs-toggle="modal"
                            data-bs-target="#profilPetaniAddModal">
                            <span class="btn-inner d-flex align-items-center">
                                Kelola Profil
                            </span>
                        </button>
                    </div>
                </div>

                <div class="row">
                    {{-- Informasi Petani --}}
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <div class="header-title">
                                    <h4 class="card-title">Informasi Petani</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(!empty($profil))
                                <ul class="list-inline m-0 p-0">
                                    <div class="pb-2">
                                        <h6>Nama Petani:
                                            <strong class="ms-1">{{ $profil->nama_petani ?? '-' }}</strong>
                                        </h6>
                                    </div>
                                    <div class="pb-2">
                                        <h6>Varietas Bibit:
                                            <strong class="ms-1">{{ $profil->varietas_bibit ?? '-' }}</strong>
                                        </h6>
                                    </div>
                                    <div class="pb-2">
                                        <h6>Luasan Lahan Total:
                                            <strong class="ms-1">{{ $profil->luasan_lahan_total ?? '-' }} Ha</strong>
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
                                </ul>
                                @else
                                <div class="alert alert-warning text-center mb-0">
                                    Belum ada data profil petani.
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
                                    <h4 class="card-title">Titik Koordinat Lahan</h4>
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
            .bindPopup("Lokasi Lahan Petani: {{ $profil->nama_petani ?? 'Tidak diketahui' }}")
            .openPopup();
        map.setView([lat, lng], 13);
    @endif
});
</script>

@include('admin.petani.profil.kelola.modal.create')
@endsection
