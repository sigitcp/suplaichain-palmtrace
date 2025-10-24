@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
    <div class="row">
        <div class="col-sm-12">

            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="card-title mb-0">Peta Persebaran Pengepul & PKS</h4>
                </div>
                <div class="card-body p-0">
                    <div id="map" style="height: 500px;"></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title mb-0">Daftar Pengepul & PKS</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengepul as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td><span class="badge bg-success">Pengepul</span></td>
                                <td class="text-center">
                                    <a href="{{ route('petani.peta.detail', ['type' => 'pengepul', 'id' => $item->id]) }}" 
                                       class="btn btn-sm btn-outline-success">Lihat Detail</a>
                                </td>
                            </tr>
                            @endforeach

                            @foreach($pks as $item)
                            <tr>
                                <td>{{ $loop->iteration + count($pengepul) }}</td>
                                <td>{{ $item->nama }}</td>
                                <td><span class="badge bg-warning text-dark">PKS</span></td>
                                <td class="text-center">
                                    <a href="{{ route('petani.peta.detail', ['type' => 'pks', 'id' => $item->id]) }}" 
                                       class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var map = L.map('map').setView([0.0645, 109.4050], 9);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var pengepulData = @json($pengepul);
    pengepulData.forEach(function(p) {
        if (p.latitude && p.longitude) {
            L.marker([p.latitude, p.longitude], {icon: L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                iconSize: [28, 28]
            })})
            .addTo(map)
            .bindPopup(`<b>${p.nama}</b><br>${p.alamat}<br><a href="peta/pengepul/${p.id}" class="btn btn-sm btn-success mt-1">Detail</a>`);
        }
    });

    var pksData = @json($pks);
    pksData.forEach(function(p) {
        if (p.latitude && p.longitude) {
            L.marker([p.latitude, p.longitude], {icon: L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/512/8944/8944870.png',
                iconSize: [28, 28]
            })})
            .addTo(map)
            .bindPopup(`<b>${p.nama}</b><br>${p.alamat}<br><a href="peta/pks/${p.id}" class="btn btn-sm btn-primary mt-1">Detail</a>`);
        }
    });
});
</script>
@endsection
