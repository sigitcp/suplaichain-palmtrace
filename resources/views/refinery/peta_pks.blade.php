@extends('layouts.master')

@section('container')
<div class="container-fluid content-inner py-3">
    <h4 class="mb-4">Peta Persebaran PKS</h4>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div id="map" style="height: 500px; border-radius: 8px;"></div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <strong>Daftar PKS</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama PKS</th>
                            <th>Alamat</th>
                            <th>Kapasitas Produksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pksList as $index => $pks)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pks->nama_pks }}</td>
                                <td>{{ $pks->alamat }}</td>
                                <td>{{ number_format($pks->kapasitas_tbs_kg ?? 0) }} Kg/hari</td>
                                <td>
                                    <a href="{{ route('pks.detail', $pks->id) }}" class="btn btn-sm btn-primary">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data PKS</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Leaflet Map --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('map').setView([0.7893, 113.9213], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        var pksList = @json($pksList);

        pksList.forEach(function(pks) {
            if (pks.latitude && pks.longitude) {
                var marker = L.marker([pks.latitude, pks.longitude]).addTo(map);
                marker.bindPopup(`
                    <strong>${pks.nama_pks}</strong><br>${pks.alamat}<br>
                    <a href="{{ url('pks/detail') }}/${pks.id}" class='btn btn-sm btn-primary mt-1'>Lihat Detail</a>
                `);
            }
        });
    });
</script>
@endsection
