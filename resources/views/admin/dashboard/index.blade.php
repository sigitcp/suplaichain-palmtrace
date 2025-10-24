@extends('layouts.master')
@section('container')
<div class="container-fluid py-4">

    {{-- Statistik Utama --}}
    <div class="row g-3 mb-4">
        <div class="col-md-2 col-6">
            <div class="card shadow-sm text-center p-3 border-start border-success border-4">
                <h6 class="text-muted">Petani</h6>
                <h3 class="fw-bold">{{ $jumlahPetani }}</h3>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card shadow-sm text-center p-3 border-start border-primary border-4">
                <h6 class="text-muted">Pengepul</h6>
                <h3 class="fw-bold">{{ $jumlahPengepul }}</h3>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card shadow-sm text-center p-3 border-start border-warning border-4">
                <h6 class="text-muted">PKS</h6>
                <h3 class="fw-bold">{{ $jumlahPks }}</h3>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card shadow-sm text-center p-3 border-start border-danger border-4">
                <h6 class="text-muted">Refinery</h6>
                <h3 class="fw-bold">{{ $jumlahRefinery }}</h3>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card shadow-sm text-center p-3 border-start border-info border-4">
                <h6 class="text-muted">Poligon Terdata</h6>
                <h3 class="fw-bold">{{ $jumlahPoligon }}</h3>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card shadow-sm text-center p-3 border-start border-secondary border-4">
                <h6 class="text-muted">Total Luas (Ha)</h6>
                <h3 class="fw-bold">{{ number_format($totalLuasLahan, 2) }}</h3>
            </div>
        </div>
    </div>

    {{-- Grafik Harga --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="card shadow-sm p-3">
                <h6 class="text-center">Harga TBS Mingguan</h6>
                <canvas id="chartTbs" height="120"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm p-3">
                <h6 class="text-center">Harga CPO Mingguan</h6>
                <canvas id="chartCpo" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Peta Persebaran --}}
    <div class="card shadow-sm p-3">
        <h6 class="text-center mb-3">Peta Persebaran</h6>
        <div id="map" style="height: 500px; border-radius: 10px;"></div>
    </div>

</div>

{{-- ChartJS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctxTbs = document.getElementById('chartTbs');
new Chart(ctxTbs, {
    type: 'line',
    data: {
        labels: {!! json_encode($tbsTanggal) !!},
        datasets: [{
            label: 'Harga TBS (Rp)',
            data: {!! json_encode($tbsHarga) !!},
            borderColor: '#198754',
            backgroundColor: 'rgba(25, 135, 84, 0.2)',
            fill: true,
            tension: 0.4
        }]
    }
});

const ctxCpo = document.getElementById('chartCpo');
new Chart(ctxCpo, {
    type: 'line',
    data: {
        labels: {!! json_encode($cpoTanggal) !!},
        datasets: [{
            label: 'Harga CPO (Rp)',
            data: {!! json_encode($cpoHarga) !!},
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.2)',
            fill: true,
            tension: 0.4
        }]
    }
});
</script>

{{-- Leaflet Map --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
const map = L.map('map').setView([-0.132, 111.096], 7); // Fokus ke Kalimantan Barat

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
}).addTo(map);

const petani = {!! json_encode($petani) !!};
petani.forEach(p => {
    if (p.latitude && p.longitude) {
        L.marker([p.latitude, p.longitude])
            .bindPopup(`<b>Petani:</b> ${p.nama}`)
            .addTo(map);
    }
});

const pengepul = {!! json_encode($pengepul) !!};
pengepul.forEach(p => {
    if (p.latitude && p.longitude) {
        L.marker([p.latitude, p.longitude])
            .bindPopup(`<b>Pengepul:</b> ${p.nama}`)
            .addTo(map);
    }
});

const pks = {!! json_encode($pks) !!};
pks.forEach(p => {
    if (p.latitude && p.longitude) {
        L.marker([p.latitude, p.longitude])
            .bindPopup(`<b>PKS:</b> ${p.nama}`)
            .addTo(map);
    }
});

const refinery = {!! json_encode($refinery) !!};
refinery.forEach(p => {
    if (p.latitude && p.longitude) {
        L.marker([p.latitude, p.longitude])
            .bindPopup(`<b>Refinery:</b> ${p.nama}`)
            .addTo(map);
    }
});

// Lahan Poligon
const lahanData = {!! json_encode($lahan) !!};
lahanData.forEach(l => {
    if (l.file_geojson) {
        fetch(`/storage/${l.file_geojson}`)
            .then(res => res.json())
            .then(geo => L.geoJSON(geo, { style: { color: 'green', weight: 2 } }).addTo(map));
    }
});
</script>
@endsection
