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



@endsection