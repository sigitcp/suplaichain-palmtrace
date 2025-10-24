@extends('layouts.master')
@section('container')

<div class="container-fluid py-4">
    {{-- ======== TOP CARDS ======== --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h4 class="fw-bold">{{ $laporanMasuk }}/Hari ini</h4>
                <p class="text-muted mb-0">Laporan Masuk</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h4 class="fw-bold">{{ number_format($tbsTerdistribusi, 0, ',', '.') }} Kg</h4>
                <p class="text-muted mb-0">TBS Dibeli</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h4 class="fw-bold">
                    Rp{{ $hargaTbs ? number_format($hargaTbs->harga_per_kg, 0, ',', '.') : '-' }}
                </h4>
                <p class="text-muted mb-0">Harga TBS per Kg</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h4 class="fw-bold">
                    Rp{{ $hargaCpo ? number_format($hargaCpo->harga_per_kg, 0, ',', '.') : '-' }}
                </h4>
                <p class="text-muted mb-0">Harga CPO per Kg</p>
            </div>
        </div>
    </div>

    {{-- ======== GRAFIK AREA ======== --}}
    <div class="row d-flex g-3 mb-4">
        {{-- ======== GRAFIK LINE HARGA TBS & CPO ======== --}}
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Grafik Harga TBS dan CPO Mingguan</h5>
                    <canvas id="grafikHarga"></canvas>
                </div>
            </div>
        </div>

        {{-- ======== GRAFIK BAR PEMBELIAN BULANAN ======== --}}
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Grafik Pembelian TBS per Bulan</h5>
                    <canvas id="grafikBar"></canvas>
                </div>
            </div>
        </div>

        {{-- ======== PIE CHART PEMBELIAN DARI PENGEPUL ======== --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Persentase Pembelian dari Pengepul</h5>
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========= SCRIPTS ========= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // === Grafik Harga Mingguan (TBS & CPO) ===
    const ctxHarga = document.getElementById('grafikHarga');
    new Chart(ctxHarga, {
        type: 'line',
        data: {
            labels: {!! json_encode($dataHargaTbs->pluck('tanggal')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))) !!},
            datasets: [
                {
                    label: 'Harga TBS (Rp/Kg)',
                    data: {!! json_encode($dataHargaTbs->pluck('harga_per_kg')) !!},
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Harga CPO (Rp/Kg)',
                    data: {!! json_encode($dataHargaCpo->pluck('harga_per_kg')) !!},
                    borderColor: '#f6c23e',
                    backgroundColor: 'rgba(246, 194, 62, 0.1)',
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } },
            scales: {
                y: {
                    beginAtZero: false,
                    ticks: { callback: value => 'Rp' + value.toLocaleString('id-ID') }
                }
            }
        }
    });

// === Grafik Bar Pembelian per Bulan ===
const ctxBar = document.getElementById('grafikBar');
new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [{
            label: 'Total Pembelian TBS (kg)',
            data: {!! json_encode(array_values($dataBulan->toArray())) !!},
            backgroundColor: '#1cc88a'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Kilogram' }
            }
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.formattedValue + ' Kg';
                    }
                }
            }
        }
    }
});


    // === Pie Chart Pembelian per Pengepul ===
    const ctxPie = document.getElementById('pieChart');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: {!! json_encode($dataPie->pluck('pengepul')) !!},
            datasets: [{
                data: {!! json_encode($dataPie->pluck('persentase')) !!},
                backgroundColor: {!! json_encode(
                    $dataPie->map(fn() => sprintf('rgba(%d, %d, %d, 0.6)', rand(60,200), rand(60,200), rand(60,200)))
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
