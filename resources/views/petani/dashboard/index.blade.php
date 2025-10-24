@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
    <div class="row">
        <div class="col-sm-12">

            <!-- Judul Section -->
            <h5 class="fw-bold mb-3 text-success">Dashboard Petani</h5>

            <div class="row g-3">

                <!-- Card Total Panen -->
                <div class="col-md-4 col-sm-6">
                    <div class="card shadow-sm border-0 h-100" style="background-color:#f3f8e5;">
                        <div class="card-body text-center">
                            <h6 class="fw-bold text-secondary mb-2">Total Panen</h6>
                            <h4 class="fw-bold text-warning">
                                {{ number_format($totalBaik + $totalReject, 0, ',', '.') }} Kg
                            </h4>
                            <p class="small mb-0 text-muted">Akumulasi semua panen</p>
                        </div>
                    </div>
                </div>

                <!-- Card Panen Terakhir -->
                <div class="col-md-4 col-sm-6">
                    <div class="card shadow-sm border-0 h-100" style="background-color:#e9f5e9;">
                        <div class="card-body text-center">
                            <h6 class="fw-bold text-secondary mb-2">Panen Terakhir</h6>
                            <h4 class="fw-bold text-success">
                                {{ number_format($totalPanenTerakhir, 0, ',', '.') }} Kg
                            </h4>
                            <p class="small mb-1 text-muted">{{ $tanggalPanenTerakhir }}</p>
                            <p class="small mb-0">Hasil penimbangan terakhir</p>
                        </div>
                    </div>
                </div>

                <!-- Card Total Reject -->
                <div class="col-md-4 col-sm-6">
                    <div class="card shadow-sm border-0 h-100" style="background-color:#fff5f3;">
                        <div class="card-body text-center">
                            <h6 class="fw-bold text-secondary mb-2">Total Reject</h6>
                            <h4 class="fw-bold text-danger">
                                {{ number_format($totalReject, 0, ',', '.') }} Kg
                            </h4>
                            <p class="small mb-0 text-muted">Total TBS tidak diterima</p>
                        </div>
                    </div>
                </div>

                <!-- Grafik Panen -->
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0" style="background-color:#f0f7de;">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Grafik Panen</h6>
                            <canvas id="chartPanen" height="120"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Card Harga Pasar -->
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 h-100" style="background-color:#eef7e5;">
                        <div class="card-body text-center">
                            <h6 class="fw-bold text-secondary mb-3">Harga Pasar (TBS)</h6>
                            <h4 class="fw-bold text-success mb-1">
                                Rp {{ number_format($hargaSekarang, 0, ',', '.') }} / Kg
                            </h4>
                            <p class="small text-muted mb-2">Harga minggu ini</p>
                            <span class="fw-bold {{ $perubahanPersen >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $perubahanPersen >= 0 ? '+' : '' }}{{ number_format($perubahanPersen, 1) }}%
                            </span>
                            <p class="small text-muted mb-0">Perubahan dari minggu lalu</p>
                            <hr class="my-2">
                            <p class="small text-muted mb-0">Sumber: <strong>Disbun Kalbar</strong></p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

{{-- === ChartJS === --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartPanen');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($labels) !!}, // berisi tanggal_penimbangan
        datasets: [
            {
                label: 'Panen Baik (Kg)',
                data: {!! json_encode($dataBaik) !!},
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.2)',
                fill: true,
                tension: 0.4
            },
            {
                label: 'Panen Reject (Kg)',
                data: {!! json_encode($dataReject) !!},
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.2)',
                fill: true,
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: { color: '#333' }
            }
        },
        scales: {
            y: { beginAtZero: true, title: { display: true, text: 'Kg' } },
            x: { title: { display: true, text: 'Tanggal Penimbangan' } }
        }
    }
});
</script>

@endsection
