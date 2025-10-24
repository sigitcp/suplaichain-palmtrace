@extends('layouts.master')
@section('container')

<div class="container-fluid py-4">
    {{-- ======== TOP CARDS ======== --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4 class="fw-bold">{{ $laporanMasuk }}/Hari ini</h4>
                <p class="text-muted mb-0">Laporan Masuk</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4 class="fw-bold">{{ number_format($tbsTerdistribusi, 0, ',', '.') }} Kg</h4>
                <p class="text-muted mb-0">TBS Terdistribusi</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4 class="fw-bold">
    Rp{{ $hargaTbs ? number_format($hargaTbs->harga_per_kg, 0, ',', '.') : '-' }}
</h4>
                <p class="text-muted mb-0">Harga TBS per Kg</p>
            </div>
        </div>
    </div>
    <div class="row d-flex g-3 mb-4">
    {{-- ======== GRAFIK LINE HARGA ======== --}}
    <div class=" col-md-6">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Grafik Harga TBS Mingguan</h5>
            <canvas id="grafikHarga"></canvas>
        </div>
    </div>
</div>
    {{-- ======== GRAFIK TBS BAGUS & REJECT ======== --}}
    <div class=" col-md-6">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Grafik TBS Bagus dan Reject</h5>
            <canvas id="grafikTbs"></canvas>
        </div>
    </div>
</div>
    {{-- ======== GRAFIK BAR PEMBELIAN & PENJUALAN ======== --}}
    <div class=" col-md-6">
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Grafik Pembelian dan Penjualan TBS per Bulan</h5>
            <canvas id="grafikBar"></canvas>
        </div>
    </div>
</div>
    {{-- ======== PIE CHART PETANI ======== --}}
    <div class=" col-md-6">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Persentase Pembelian dari Petani</h5>
            <canvas id="pieChart"></canvas>
        </div>
    </div>
</div>
    </div>
</div>

{{-- ========= SCRIPTS ========= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Harga Mingguan
    const ctxHarga = document.getElementById('grafikHarga');
    new Chart(ctxHarga, {
        type: 'line',
        data: {
            labels: {!! json_encode($dataHarga->pluck('tanggal')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))) !!},
            datasets: [{
                label: 'Harga TBS',
                data: {!! json_encode($dataHarga->pluck('harga_per_kg')) !!},
                borderColor: '#4e73df',
                tension: 0.3
            }]
        }
    });

    // Grafik TBS Bagus & Reject
    const ctxTbs = document.getElementById('grafikTbs');
    new Chart(ctxTbs, {
        type: 'line',
        data: {
            labels: {!! json_encode($grafikTbs->pluck('tanggal')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))) !!},
            datasets: [
                { label: 'TBS Bagus (kg)', data: {!! json_encode($grafikTbs->pluck('total_baik')) !!}, borderColor: '#1cc88a', tension: 0.3 },
                { label: 'TBS Reject (kg)', data: {!! json_encode($grafikTbs->pluck('total_reject')) !!}, borderColor: '#e74a3b', tension: 0.3 }
            ]
        }
    });

    // Grafik Bar Bulanan
    const ctxBar = document.getElementById('grafikBar');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [
                { label: 'Pembelian TBS (kg)', data: {!! json_encode($pembelianPerBulan->values()) !!}, backgroundColor: '#36b9cc' },
                { label: 'Penjualan TBS (kg)', data: {!! json_encode($penjualanPerBulan->values()) !!}, backgroundColor: '#1cc88a' }
            ]
        },
        options: { responsive: true }
    });

    // Pie Chart Petani
const ctxPie = document.getElementById('pieChart');
new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: {!! json_encode($dataPie->pluck('petani')) !!},
        datasets: [{
            data: {!! json_encode($dataPie->pluck('persentase')) !!},
            backgroundColor: {!! json_encode(
                $dataPie->map(fn() => sprintf('rgba(%d, %d, %d, 0.6)', rand(50,255), rand(50,255), rand(50,255)))
            ) !!}
        }]
    },
    options: {
        plugins: {
            legend: { position: 'bottom' },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.label + ': ' + context.formattedValue + '%';
                    }
                }
            }
        }
    }
});

</script>
@endsection
