@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
    <div class="row">
        <div class="col-sm-12">

            <div class="row g-3">
                {{-- ==================== CARD INFORMASI LAHAN ==================== --}}
                <div class="col-lg-5">
                    <div class="card mb-0">
                        <div class="card-header">
                            <div class="header-title">
                                <h4 class="card-title">Informasi Lahan</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-inline p-0">
                                <div class="pb-2">
                                    <h5>Nama Lahan:
                                        <strong class="ms-1">{{ $lahan->nama_lahan ?? '-' }}</strong>
                                    </h5>
                                </div>
                                <div class="pb-2">
                                    <h5>Nama Pemilik/PIC:
                                        <strong class="ms-1">{{ $detail->penanggung_jawab ?? '-' }}</strong>
                                    </h5>
                                </div>
                                <div class="pb-2">
                                    <h5>Luas Lahan:
                                        <strong class="ms-1">{{ $detail->luas_kebun ?? '-' }} Ha</strong>
                                    </h5>
                                </div>
                                <div class="pb-2">
                                    <h5>Alamat:
                                        @if(!empty($lahan->alamat))
                                        <a href="{{ $lahan->gmaps_link ?? '#' }}" target="_blank">
                                            <strong class="ms-1">{{ $lahan->alamat }}</strong>
                                        </a>
                                        @else
                                        <strong class="ms-1">-</strong>
                                        @endif
                                    </h5>
                                </div>
                            </ul>
                        </div>
                    </div>

                    {{-- ==================== CARD SERTIFIKAT ==================== --}}
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="header-title">
                                <h4 class="card-title">Sertifikat Lahan</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(!empty($detail) && $detail->sertifikat)
                            <iframe src="{{ asset('storage/' . $detail->sertifikat) }}"
                                height="400px" width="100%" style="border: none;"></iframe>
                            @else
                            <div class="alert alert-warning text-center">
                                Sertifikat belum diunggah.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ==================== CARD PETA LAHAN ==================== --}}
                <div class="col-lg-7">
                    <div class="card mb-3 mt-0">
                        <div class="card-header d-flex align-items-center justify-content-between pb-4">
                            <div class="header-title">
                                <h4 class="card-title mb-0">Peta Lahan</h4>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div id="map" style="width: 100%; height: 400px;"></div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
    <div class="card border-4 border-0">
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center text-center">
                <div>
                    <h5 style="color: #858223;">{{ number_format($totalPanen, 0, ',', '.') }} Kg</h5>
                    <span>Total Panen</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 align-items-stretch">
    {{-- Rata-rata panen perhari --}}
    <div class="col-lg-3 col-6">
        <div class="card border-4 border-0 h-100">
            <div class="card-body px-3 d-flex justify-content-center align-items-center text-center">
                <div>
                    <h5 style="color: #858223; margin-bottom:6px;">{{ number_format($rataRataPanen, 0, ',', '.') }} Kg</h5>
                    <h6 style="font-size: 12px;">Rata-rata Panen Perhari</h6>
                </div>
            </div>
        </div>
    </div>

    {{-- Panen terakhir --}}
    <div class="col-lg-3 col-6">
        <div class="card border-4 border-0 h-100">
            <div class="card-body px-3 d-flex justify-content-center align-items-center text-center">
                <div>
                    <h5 style="color: #858223; margin-bottom:6px;">
                        {{ $panenTerakhir ? number_format($panenTerakhir->jumlah_pokok, 0, ',', '.') : '-' }} Kg
                    </h5>
                    <h6 style="font-size: 12px;">Panen Terakhir</h6>
                    <p class="text-primary text-decoration-underline mb-0" style="font-size: 12px;">
                        {{ $panenTerakhir ? \Carbon\Carbon::parse($panenTerakhir->tanggal_panen)->translatedFormat('d F Y') : '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Hari panen aktif --}}
    <div class="col-lg-3 col-6">
        <div class="card border-4 border-0 h-100">
            <div class="card-body px-3 d-flex justify-content-center align-items-center text-center">
                <div>
                    <h5 style="color: #858223; margin-bottom:6px;">{{ $hariPanenAktif }} Kali</h5>
                    <h6 style="font-size: 12px;">Hari Panen Aktif</h6>
                </div>
            </div>
        </div>
    </div>

    {{-- Panen tertinggi --}}
    <div class="col-lg-3 col-6">
        <div class="card border-4 border-0 h-100">
            <div class="card-body px-3 d-flex justify-content-center align-items-center text-center">
                <div>
                    <h5 style="color: #858223; margin-bottom:6px;">
                        {{ $panenTertinggi ? number_format($panenTertinggi->jumlah_pokok, 0, ',', '.') : '-' }} Kg
                    </h5>
                    <h6 style="font-size: 12px;">Panen Tertinggi</h6>
                    <p class="text-primary text-decoration-underline mb-0" style="font-size: 12px;">
                        {{ $panenTertinggi ? \Carbon\Carbon::parse($panenTertinggi->tanggal_panen)->translatedFormat('d F Y') : '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


                </div>
                <div class="col-sm-12">
                    <div class="">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h5><strong>Riwayat Panen</strong></h5>
                            </div>
                            <div>
                                <button
                                    class="btn btn-sm btn-primary rounded"
                                    title="Kelola panen"
                                    data-bs-toggle="modal"
                                    data-bs-target="#panenAddModal">
                                    <i class="bi bi-plus-lg me-1"></i>
                                    <span class="btn-inner">Tambah</span>
                                </button>
                            </div>
                        </div>
                        <div class="card mt-1 px-0">
                            <div class="table-responsive rounded">
                                <table class="table table-striped" role="grid" data-bs-toggle="data-table">
                                    <thead>
                                        <tr style="background-color: #E3C923; color:black">
                                            <th>no</th>
                                            <th>tanggal</th>
                                            <th>jumlah pokok</th>
                                            <th>Rata-rata per pokok</th>
                                            <th>kualitas</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($panens as $index => $panen)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($panen->tanggal_panen)->translatedFormat('d F Y') }}</td>
                                            <td>{{ $panen->jumlah_pokok }} Kg</td>
                                            <td>{{ $panen->jumlah_perpokok }} Kg</td>
                                            <td>
                                                @if ($panen->kualitas == 'unggul')
                                                <div class="bg-info text-center text-white p-1 rounded">{{ ucfirst($panen->kualitas) }}</div>
                                                @elseif ($panen->kualitas == 'cukup')
                                                <div class="bg-warning text-center text-white p-1 rounded">{{ ucfirst($panen->kualitas) }}</div>
                                                @elseif ($panen->kualitas == 'baik')
                                                <div class="bg-primary text-center text-white p-1 rounded">{{ ucfirst($panen->kualitas) }}</div>
                                                @else
                                                <div class="bg-secondary text-center text-white p-1 rounded">Tidak diketahui</div>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-sm btn-warning rounded" data-bs-toggle="modal" data-bs-target="#panenEditModal{{ $panen->id }}">
                                                        Edit
                                                    </button>
                                                    <button class="btn btn-sm btn-danger rounded" data-bs-toggle="modal" data-bs-target="#panenDeleteModal{{ $panen->id }}">
                                                        Hapus
                                                    </button>
                                                </div>
                                                @include('petani.monitoring.modal.edit', ['panen' => $panen])
                                                @include('petani.monitoring.modal.delete', ['panen' => $panen])
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada data panen</td>
                                        </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ==================== LEAFLET JS ==================== --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pusat tampilan default: Kalimantan Barat
        var map = L.map('map').setView([0.0645, 109.4050], 7);

        // Tambahkan layer peta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        @if(!empty($detail) && $detail -> file_geojson)
        // Jika ada file GeoJSON
        fetch("{{ asset('storage/' . $detail->file_geojson) }}")
            .then(response => response.json())
            .then(data => {
                var geojsonLayer = L.geoJSON(data, {
                    style: {
                        color: "#28a745",
                        weight: 2,
                        fillOpacity: 0.3
                    }
                }).addTo(map);

                // Auto zoom ke batas poligon
                map.fitBounds(geojsonLayer.getBounds());

                geojsonLayer.bindPopup("<b>📍 Poligon lahan ditemukan</b>");
            })
            .catch(error => {
                console.error("Gagal memuat GeoJSON:", error);
                L.popup()
                    .setLatLng([0.0645, 109.4050])
                    .setContent("⚠️ Gagal memuat file GeoJSON lahan")
                    .openOn(map);
            });
        @else
        // Jika belum ada file GeoJSON
        const infoControl = L.control({
            position: 'topcenter'
        });

        infoControl.onAdd = function(map) {
            this._div = L.DomUtil.create('div', 'no-geojson-info');
            this._div.innerHTML = `
                    <div style="
                        background: rgba(255,255,255,0.95);
                        padding: 10px 20px;
                        border-radius: 10px;
                        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                        font-weight: 600;
                        text-align: center;
                    ">
                        ⚠️ Belum ada file poligon lahan
                    </div>`;
            return this._div;
        };
        infoControl.addTo(map);
        @endif
    });
</script>


@include('petani.monitoring.modal.create')

@endsection